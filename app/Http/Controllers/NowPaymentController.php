<?php

namespace App\Http\Controllers;

use App\Http\Requests\NowPaymentRequest;
use App\Models\CryptoPayment;
use App\Models\HistoryBank;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class NowPaymentController extends Controller
{
    public function create_payment(NowPaymentRequest $request)
    {
        $crypto_payment = CryptoPayment::create([
            'user_id' => Auth::user()->id,
            'order_id' => 'order-' . time(),
            'amount' => $request->amount,
            'status' => 'waiting',
        ]);

        $ipnUrl = route('nowpayment.callback'); 
        $returnurl = route('naptien'); 
        $systemurl = route('naptien');
        $client = new Client([
            'base_uri' => 'https://api.nowpayments.io/v1/',
        ]);

        $response = $client->request('POST', 'invoice', [
            'headers' => [
                'x-api-key' => getSetting('nowpayment_apikey'),
            ],
            'json' => [
                "price_amount" => $request->amount,
                "price_currency" => "usd",
                "order_id" => $crypto_payment->order_id,
                "order_description" => "Deposit to wallet",
                "ipn_callback_url" => $ipnUrl,
                "success_url" => $returnurl.'?crypto_status=success',
                "cancel_url" => $systemurl
            ]
        ]);
        if ($response) {
            $res = json_decode($response->getBody()->getContents());
            return Redirect::to($res->invoice_url);
        } else {
            return back();
        }
    
    }

    public function callback()
    {
        $success = $this->checkIpnRequest();

        $requestJson = file_get_contents('php://input');
        $requestData = json_decode($requestJson, true);

        $transactionId = $requestData['payment_id'];
        $orderId = $requestData['order_id'];
        $priceAmount = $requestData['price_amount'];
        $paymentAmount = $requestData['pay_amount'];


        if ($success) {
            $status = $requestData["payment_status"];
            $crypto_payment = CryptoPayment::where('order_id', $orderId)->first();
            if (!empty($crypto_payment)) {
                $crypto_payment->status = $status;
                $crypto_payment->payment_id = $transactionId;
                $crypto_payment->save();
            }
            if ($status == "finished") {
                if (!empty($crypto_payment)) {
                    $user = User::find($crypto_payment->user_id);
                    $user->coin += $paymentAmount * getSetting('paypal_rate');
                    $user->save();
                    HistoryBank::create([
                        'user_id' => $user->id,
                        'trans_id' => 'CRYPTO - ' . $transactionId,
                        'coin' => $paymentAmount * getSetting('paypal_rate'),
                        'memo' => "OrderId ${orderId} has been paid. Amount received",
                        'type' => 'Nạp tiền từ Crypto',
                    ]);
                    Log::info("OrderId ${orderId} has been paid. Amount received: ${paymentAmount}");
                }
            } else if ($status == "partially_paid") {
                //thanh toán 1 phần
                $actuallyPaid = $requestData["actually_paid"];
                Log::info("Your payment ${$orderId} is partially paid. Please contact support@nowpayments.io. Expected amount received: ${paymentAmount}. Amount received: ${actuallyPaid}. " . "ID invoice: " . $requestData['payment_id'] . ".");
            } else if ($status == "confirming") {
                Log::info("OrderId ${orderId} has been confirming. Amount received: ${paymentAmount}");
            } else if ($status == "confirmed") {
                Log::info("OrderId ${orderId} has been confirmed. Amount received: ${paymentAmount}");
            } else if ($status == "sending") {
                Log::info("OrderId ${orderId} has been sending. Amount received: ${paymentAmount}");
            } else if ($status == "failed") {
                Log::info("OrderId ${orderId} has been failed. Amount received: ${paymentAmount}");
            } else if ($status == "waiting") {
                Log::info("OrderId ${orderId} has been waiting. Amount received: ${paymentAmount}");
            }
        } else {
            die('IPN Verification Failure');
        }
    }

    protected function checkIpnRequest() 
    {
        if (isset($_SERVER['HTTP_X_NOWPAYMENTS_SIG']) && !empty($_SERVER['HTTP_X_NOWPAYMENTS_SIG'])) {
            $receivedHmac = $_SERVER['HTTP_X_NOWPAYMENTS_SIG'];
            $requestJson = file_get_contents('php://input');
            if ($requestJson !== false && !empty($requestJson)) {
                $requestData = json_decode($requestJson, true);
                ksort($requestData);
                $sortedRequestJson = json_encode($requestData);
                $hmac = hash_hmac('sha512', $sortedRequestJson, trim(getSetting('nowpayment_ipn')));
                if ($hmac == $receivedHmac) {
                    return true;
                } else {
                    return false;
                }
            } else {
                Log::info("Error reading POST data: ".$requestJson);
                die('Error reading POST data');
            }
        } else {
            Log::info("No HMAC signature sent. ");
            die('No HMAC signature sent');
        }
    }

    public function perfectmoney_callback(Request $request)
    {
        $dataPost = $request->all();
        $string=
            $dataPost['PAYMENT_ID'].':'.$dataPost['PAYEE_ACCOUNT'].':'.
            $dataPost['PAYMENT_AMOUNT'].':'.$dataPost['PAYMENT_UNITS'].':'.
            $dataPost['PAYMENT_BATCH_NUM'].':'.
            $dataPost['PAYER_ACCOUNT'].':'.strtoupper(md5(getSetting('perfectmoney_pass'))).':'.
            $dataPost['TIMESTAMPGMT'];

        $hash=strtoupper(md5($string));
        
        if($hash==$_POST['V2_HASH']){ // processing payment if only hash is valid
            if($_POST['PAYEE_ACCOUNT'] == getSetting('perfectmoney_id') && $_POST['PAYMENT_UNITS'] == 'USD'){
                Log::info("Success: ".json_encode($request->all()));
                $explode_payment_id = explode('-', $dataPost['PAYMENT_ID']);
                $user_id = $explode_payment_id[1];
                $user = User::find($user_id);
                $user->coin += $dataPost['PAYMENT_AMOUNT'] * getSetting('paypal_rate');
                $user->save();
                HistoryBank::create([
                    'user_id' => $user->id,
                    'trans_id' => 'PM - ' . $dataPost['PAYMENT_ID'],
                    'coin' => $dataPost['PAYMENT_AMOUNT'] * getSetting('paypal_rate'),
                    'memo' => "OrderId ".$dataPost['PAYMENT_ID']." has been paid. Amount received",
                    'type' => 'Nạp tiền từ PM',
                ]);
                Log::info("OrderId ".$dataPost['PAYMENT_ID']." has been paid. Amount received: ".$dataPost['PAYMENT_AMOUNT']);
            }else{
                Log::error("Fake data: ".json_encode($request->all()));
            }
        
        }else{
                
            Log::error("Fail :".json_encode($request->all()));
        
        }
    }
}
