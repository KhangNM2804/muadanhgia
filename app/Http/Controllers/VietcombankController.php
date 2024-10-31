<?php

namespace App\Http\Controllers;

use App\Models\HistoryBank;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use phpseclib\Crypt\RSA;

class VietcombankController extends Controller
{
    public function autoVCB()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.vnitshare.com/vcb/transactions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => 'username='.getSetting('bank_user').'&password='.getSetting('bank_pass').'&account_number='.getSetting('bank_account'),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
        
        } else {
            $ChiTietGiaoDich = json_decode($response, TRUE);
            if($ChiTietGiaoDich['data'] && $ChiTietGiaoDich['data']['ChiTietGiaoDich']){
                var_dump($ChiTietGiaoDich['data']['ChiTietGiaoDich']);
                foreach ($ChiTietGiaoDich['data']['ChiTietGiaoDich'] as $value){
                    
                    
                        $str = $value['MoTa'];
                        $cuphap = getSetting('bank_syntax');
                        $upcase = strtolower($cuphap);
                        $str= preg_replace("/".$upcase."/i", getSetting('bank_syntax'), $str);
                        $str= preg_replace('!\s+!', ' ', $str);

                        $index = strpos($str,$cuphap);
                        if(preg_match('/'.$cuphap.' ([0-9]{0,})/', $str, $matches)){
                            $user_id = $matches[1];
                            $vnd = (int)str_replace(',', '',$value['SoTienGhiCo']);
                            $check_exit = HistoryBank::where('memo', $value['MoTa'])->first();
                            if(empty($check_exit)){
                                $updateUser = User::find($user_id);
                                if(!empty($updateUser)){

                                    $sale_rate = !empty(getSetting('sale_rate')) ? (int)getSetting('sale_rate') : 0;
                                    $min_amount_sale_rate = !empty(getSetting('min_amount_sale_rate')) ? (int)getSetting('min_amount_sale_rate') : 0;
                                    if($vnd >= $min_amount_sale_rate){
                                        $total_dep = $vnd + ($vnd * ($sale_rate/100));
                                    }else{
                                        $total_dep = $vnd;
                                    }

                                    $updateUser->coin += $total_dep;
                                    $updateUser->total_coin += $total_dep;
                                    $updateUser->save();
                                    //
                                    HistoryBank::create([
                                        'user_id' => $user_id,
                                        'trans_id' => $value['SoThamChieu'],
                                        'coin' => $total_dep,
                                        'memo' => $value['MoTa'],
                                        'type' => 'Nạp tiền từ Vietcombank',
                                    ]);
                                    //cong afff
                                    if(!empty($updateUser->master_user_id)){
                                        $masterUser = User::find($updateUser->master_user_id);
                                        if($masterUser){
                                            $aff_rate = !empty(getSetting('aff_rate')) ? (int)getSetting('aff_rate') : 15;
                                            $masterUser->coin += $vnd * ($aff_rate/100);
                                            $masterUser->total_coin += $vnd * ($aff_rate/100);
                                            $masterUser->save();
    
                                            HistoryBank::create([
                                                'user_id' => $masterUser->id,
                                                'trans_id' => rand(),
                                                'coin' => $vnd * ($aff_rate/100),
                                                'memo' => "Nhận hoa hồng nạp tiền từ thành viên cấp dưới - ".$updateUser->username,
                                                'type' => 'Nhận hoa hồng nạp tiền từ thành viên cấp dưới',
                                            ]);
                                        }
                                    }
                                    
                                    //
                                }
                                
                            }
                        }
                }

            }
            
        }   
    }

    public function api(Request $request){
        $username = $request->input("username");
        $password = $request->input("password");
        $account_number = $request->input("account_number");
        $fromDate = $request->input("fromDate") ?? date("d/m/Y", time() - 172800);
        $toDate = $request->input("toDate") ?? date("d/m/Y", time() + 86400);

        $captcha_id = "30a350c5-ae30-7d0e-ec90-".randomStr(12);

        $loginData = json_encode([
            'captcha_id' =>  $captcha_id,
            'clientKey' =>  $this->pairPublicLoginKey,
            'lang' =>  "vi",
            'password' =>  $password,
            'socket_id' =>  "Xh6NSWHIb-bzfPPLAEvi",
            'user_name' =>  $username
        ]);

        $queryData = json_encode([
            'user_name' => $username,
            'client_key' => $this->readTransactionPairPublicKey,
            'data' => [
                'accountNo' => $account_number,
                'accountType' => "D",
                'cif' => "",
                'fromDate' => $fromDate,
                'lang' => "vi",
                'lengthInPage' => 999999,
                'pageIndex' => 0,
                'processCode' => "laysaoketaikhoan",
                'sessionId' => "",
                'stmtDate' => "",
                'stmtType' => "",
                'toDate' => $toDate
            ]
        ]);

        $result = false; 
        if(file_exists($username . '_token.txt') && file_exists($username . '_cookie.txt')) {
            $result = $this->readTransactionDataResult($queryData, $username);
            if(!$result) {
                $res_valid_captcha = $this->valid_captcha($captcha_id);
                if(isset($res_valid_captcha['code']) && $res_valid_captcha['code'] == "00") {
                    $res_auth_login = $this->loginVCB($loginData, $username);
                    if($res_auth_login) {
                        $result = $this->readTransactionDataResult($queryData, $username);
                    }
                }
            }
        } else {
            $res_valid_captcha = $this->valid_captcha($captcha_id);
            if(isset($res_valid_captcha['code']) && $res_valid_captcha['code'] == "00") {
                $res_auth_login = $this->loginVCB($loginData, $username);
                if($res_auth_login) {
                    $result = $this->readTransactionDataResult($queryData, $username);
                }
            }
        }
        if($result) {
            $data = [
                'status' => true,
            ];

            $tran_format = collect($result['transactions'])->map(function($tran) {
                return [
                    "SoThamChieu" => $tran->Reference,
                    "SoTienGhiCo" => $tran->Amount,
                    "MoTa" => $tran->Description,
                    "NgayGiaoDich" => $tran->TransactionDate,
                    "CD" => $tran->CD,
                ];
            });

            $data['data']['ChiTietGiaoDich'] = $tran_format->toArray();
            return response()->json($data);
        }

    }

    protected function valid_captcha($captcha_id){
        $client = new Client();
        $response = $client->request('GET', 'https://vcbdigibank.vietcombank.com.vn/w1/get-captcha/' . $captcha_id);
        $base64 = base64_encode($response->getBody());

        $resolved_captcha = $client->request('POST', 'http://94.237.78.31/v1/api/vcb/captcharesolved', [
            'headers' => [
                'Connection' => 'keep-alive',
                'Accept' => 'application/json, text/plain, */*',
                'Accept-Language' => 'vi',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
                'Content-Type' => 'application/json',
                'Sec-Fetch-Site' => 'same-origin',
                'Sec-Fetch-Mode' => 'cors',
                'Sec-Fetch-Dest' => 'empty',
            ],
            'body' => json_encode([
                'img_base64' => 'data:image/jpeg;base64,'.$base64
            ])
        ]);
        $data_captcha = $resolved_captcha->getBody()->getContents();
        $data_captcha = json_decode($data_captcha, true);
        // dd($data_captcha);

        //valid-captcha
        $valid_captcha = $client->request('POST', 'https://vcbdigibank.vietcombank.com.vn/w1/valid-captcha', [
            'headers' => [
                'Connection' => 'keep-alive',
                'Accept' => 'application/json, text/plain, */*',
                'Accept-Language' => 'vi',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
                'Content-Type' => 'application/json',
                'Origin' => 'https://vcbdigibank.vietcombank.com.vn',
                'Sec-Fetch-Site' => 'same-origin',
                'Sec-Fetch-Mode' => 'cors',
                'Sec-Fetch-Dest' => 'empty',
                'Referer' => 'https://vcbdigibank.vietcombank.com.vn/',
                'Cookie' => '_ga=GA1.3.1424465432.1589366140; _gid=GA1.3.1320200965.1595905754'
            ],
            'body' => json_encode([
                "captcha_id" => $captcha_id,
                "captcha_text" => $data_captcha['data']['captcha']
            ])
        ]);
        $res_valid_captcha = $valid_captcha->getBody()->getContents();
        $res_valid_captcha = json_decode($res_valid_captcha, true);

        return $res_valid_captcha;
    }

    protected function loginVCB($loginData, $username)
    {
        $client = new Client();
        $auth_login = $client->request('POST', 'https://vcbdigibank.vietcombank.com.vn/w1/auth', [
            'headers' => [
                'Connection' => 'keep-alive',
                'Accept' => 'application/json, text/plain, */*',
                'Accept-Language' => 'vi',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
                'Content-Type' => 'application/json',
                'Origin' => 'https://vcbdigibank.vietcombank.com.vn',
                'Sec-Fetch-Site' => 'same-origin',
                'Sec-Fetch-Mode' => 'cors',
                'Sec-Fetch-Dest' => 'empty',
                'Referer' => 'https://vcbdigibank.vietcombank.com.vn/',
                'Cookie' => '_ga=GA1.3.1424465432.1589366140; _gid=GA1.3.1320200965.1595905754'
            ],
            'body' => json_encode([
                "data" => $this->encrypt($loginData, $this->publicLoginKey),
            ])
        ]);

        $res_auth_login = $auth_login->getBody()->getContents();
        $res_auth_login = json_decode($res_auth_login, true);
        if(isset($res_auth_login['code']) && $res_auth_login['code'] == "00") {
            //login thành công
            $dataLoginDecode = $this->decrypt($res_auth_login['data'],$this->privateLoginKey);
            $dataLoginDecode = (array)$dataLoginDecode;
            if(isset($dataLoginDecode['code']) && $dataLoginDecode['code'] == "00") {
                $fp = fopen($username . '_cookie.txt', 'w');
                fwrite($fp, $auth_login->getHeader('Set-Cookie')[0] ?? '');
                fclose($fp);
                $fp = fopen($username . '_token.txt', 'w');
                fwrite($fp, $dataLoginDecode['token'] ?? '');
                fclose($fp);

                return true;
            }
        }
        return false;
    }

    protected function readTransactionDataResult($queryData, $username){
        try {
            $client = new Client();
            $encodeReadTransactionDataResult = $this->encrypt($queryData, $this->readTransactionPublicKey);
            $read_history = $client->request('POST', 'https://vcbdigibank.vietcombank.com.vn/w1/process-ib', [
                'headers' => [
                    'Connection' => 'keep-alive',
                    'Accept' => 'application/json, text/plain, */*',
                    'Authorization' => 'Bearer ' . (file_exists($username . '_token.txt')?file_get_contents($username . '_token.txt'):'xx'),
                    'Accept-Language' => 'vi',
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
                    'Content-Type' => 'application/json',
                    'Origin' => 'https://vcbdigibank.vietcombank.com.vn',
                    'Sec-Fetch-Site' => 'same-origin',
                    'Sec-Fetch-Mode' => 'cors',
                    'Sec-Fetch-Dest' => 'empty',
                    'Referer' => 'https://vcbdigibank.vietcombank.com.vn/',
                    'Cookie' => (file_exists($username . '_cookie.txt')?file_get_contents($username . '_cookie.txt'):'')
                ],
                'body' => json_encode([
                    "data" => $encodeReadTransactionDataResult
                ])
            ]);
            $res_read_history = $read_history->getBody()->getContents();
            $res_read_history = json_decode($res_read_history, true);

            if(isset($res_read_history['code']) && $res_read_history['code'] == "00") {
                $decodeDataResponse = $this->decrypt($res_read_history['data'], $this->readTransactionPrivateKey);
                $decodeDataResponse = (array) $decodeDataResponse;
                return $decodeDataResponse;
            }
            return false;
        } catch (ClientException $e) {
            return false;
        }
    }

    protected function encrypt($str, $publicKey){
        $key = randomStr(32);
        $rsa = new RSA();
        $rsa->loadkey($publicKey);
        $rsa->setEncryptionMode (2);
        $header = base64_encode($rsa->encrypt(base64_encode($key)));
        $body = base64_encode(openssl_encrypt($str, 'AES-256-ECB', $key, OPENSSL_RAW_DATA));
        return "{$header}@@@@@@{$body}";
    }

    protected function decrypt($cipherText, $privateKey) {
        $header = substr($cipherText, 0, 344);
        $body = base64_decode(substr($cipherText, 344));
        $rsa = new RSA();
        $rsa->loadKey($privateKey);
        $rsa->setEncryptionMode (2);
        $key = $rsa->decrypt(base64_decode($header));
        $text = openssl_decrypt($body, 'AES-192-ECB', base64_decode($key), OPENSSL_RAW_DATA);
        return json_decode($text);
    }
}
