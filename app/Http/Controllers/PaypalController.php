<?php

namespace App\Http\Controllers;

use App\Models\HistoryBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaypalController extends Controller
{
    public function callback(Request $request){
        $data = $request->all();

        $secret = base64_encode(getSetting('paypal_client_id').':'.getSetting('paypal_secret'));
        
        $api_url = (env('PAYPAL_ENV') == "sanbox") ? config('paypal.sanbox') : config('paypal.product') ;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $api_url. "/v2/checkout/orders/" . $data['order_id'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => ['Content-Type: application/json' , 'Authorization: Basic ' .$secret]
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $res = json_decode($response, true);
        if(!empty($res)) {
            if(isset($res['intent']) && isset($res['status']) && $res['intent'] == "CAPTURE" && $res['status'] == "COMPLETED") {
                $checkExit = HistoryBank::where('trans_id', $data['order_id'])->first();
                if(empty($checkExit)){
                    DB::beginTransaction();
                    $user = Auth::user();
                    $usd = $res['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['gross_amount']['value'];
                    $usd_fee = $res['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['value'];
                    $net_usd = $res['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['value'];
                    $paypal_rate = getSetting('paypal_rate') ?? 24000;
                    $amount = $net_usd * $paypal_rate;
                    $user->coin += $amount;
                    $user->total_coin += $amount;
                    $user->save();
                    //
                    HistoryBank::create([
                        'user_id' => $user->id,
                        'trans_id' => $data['order_id'],
                        'coin' => $amount,
                        'memo' => 'Nạp tiền từ paypal: '. $usd. '$ - ' .$usd_fee. '$ fee = ' .$net_usd. '$ (' .number_format($amount).' VND)',
                        'type' => 'Paypal',
                    ]);
                    DB::commit();
                    return response()->json([
                    'status' => true, 
                    'coin' => number_format($user->coin),
                    'msg' => 'Paypal: Nạp thành công với số tiền: '. $usd. '$ - ' .$usd_fee. '$ fee = ' .$net_usd. '$ (' .number_format($amount).' VND)'
                ]);
                }
            }else {
                return response()->json(['status' => false, 'msg' => 'Đơn hàng đã được xử lý']);
            }
        }else{
            return response()->json(['status' => false, 'msg' => 'Đơn hàng đã được xử lý']);
        }
    }
}
