<?php

namespace App\Http\Controllers;

use App\Models\Momo;
use Illuminate\Http\Request;
use phpseclib\Crypt\RSA;
use App\Models\HistoryBank;
use App\Models\User;
use Illuminate\Support\Str;

class MomoController extends Controller
{
    public $config = array(
        "momo_appVer" => "30232",
        "momo_appCode" => "3.0.23",
        "momo_key" => "Stringbatkydai32kituladuoc123456",
        "momo_deviceOS" => "IOS",
        "momo_userAgent" => 'MoMoPlatform-Release/30232 CFNetwork/1240.0.4 Darwin/20.6.0'
    );
    public function index(){
        $momos = Momo::all();
        return view('momo.index', compact('momos'));
    }

    public function naptien(){
        $momo = Momo::where('flag_auto', 1)->first();
        $nameMomo = "";
        if($momo){
            $nameMomo = $this->Momo_getInfo($momo->username);
        }
        $random = Str::random(6);
        return view('dashboard.naptien', compact('momo', 'nameMomo', 'random'));
    }

    public function add(Request $request, $phone = null){
        return view('momo.create',compact('phone'));
    }

    public function get_otp(Request $request){
        if(empty($request->username)){
            return response()->json(['status' => false, 'msg' => "Vui lòng nhập số điện thoại"]);
        }else{
            $momo = Momo::where('username', $request->username)->first();
            if(empty($momo)){
                $newMomo = new Momo();
                $newMomo->username = $request->username;
                $newMomo->rkey = $this->get_rkey(20);
                $newMomo->onesignal = $this->get_onesignal();
                $newMomo->imei = $this->get_imei();
                $newMomo->save();
                $data_momo = $newMomo->toArray();
                $result = $this->Momo_getOtp($data_momo);
                if(isset($result['result']) && $result['result'] == true){
                    return response()->json(['status' => true, 'msg' => "Lấy OTP thành công"]);
                }else{
                    return response()->json(['status' => true, 'msg' => "Lỗi hệ thống"]);
                }
            }else{
                $momo->username = $request->username;
                $momo->rkey = $this->get_rkey(20);
                $momo->onesignal = $this->get_onesignal();
                $momo->imei = $this->get_imei();
                $momo->save();
                $data_momo = $momo->toArray();
                $result = $this->Momo_getOtp($data_momo);
                if(isset($result['result']) && $result['result'] == true){
                    return response()->json(['status' => true, 'msg' => "Lấy OTP thành công"]);
                }else{
                    return response()->json(['status' => true, 'msg' => "Lỗi hệ thống"]);
                }
            }
        }
    }
    
    public function check_otp(Request $request){
        if(empty($request->username) || empty($request->otp)){
            return response()->json(['status' => false, 'msg' => "Vui lòng nhập số điện thoại và otp"]);
        }else{
                $data_momo = Momo::where('username', $request->username)->first()->toArray();
                $result = $this->Momo_checkOtp($data_momo,$request->otp);
                
                if($result){
                    return response()->json(['status' => true, 'msg' => "Check OTP thành công! Vui lòng đăng nhập"]);
                }else{
                    return response()->json(['status' => false, 'msg' => "OTP không đúng hoặc lỗi hệ thống"]);
                }
        }
    }
    
    public function login(Request $request){
        if(empty($request->username) || empty($request->password)){
            return response()->json(['status' => false, 'msg' => "Vui lòng nhập số điện thoại và password"]);
        }else{
                $data_momo = Momo::where('username', $request->username)->first();
                $data_momo->password = $request->password;
                $data_momo->save();
                $data_momo = $data_momo->toArray();
                $result = $this->Momo_login($data_momo);
                
                if($result){
                    return response()->json(['status' => true, 'msg' => "Đăng nhập thành công"]);
                }else{
                    return response()->json(['status' => false, 'msg' => "Đăng nhập không thành công"]);
                }
        }
    }
    
    public function relogin(Request $request){
        if(empty($request->username)){
            return response()->json(['status' => false, 'msg' => "Tài khoản không tồn tại"]);
        }else{
                $data_momo = Momo::where('username', $request->username)->first();
                $result = $this->Momo_login($data_momo);
                if($result){
                    return response()->json(['status' => true, 'msg' => "Đăng nhập thành công"]);
                }else{
                    return response()->json(['status' => false, 'msg' => "Đăng nhập không thành công"]);
                }
        }
    }
    
    public function set_auto(Request $request){
        
        $momo = Momo::find($request->id);
        if($request->checked == "true"){
            $momos = Momo::all();
            foreach($momos as $momo2){
                $momo2->flag_auto = 0;
                $momo2->save();
            }
            $momo->flag_auto = 1;
        }else{
            $momo->flag_auto = 0;
        }
        $momo->save();
        return response()->json(['status' => true, 'checked' => $request->checked, 'id'=>$request->id, 'msg' => "Set thành công"]);
    }
    
    public function getinfo(Request $request){
        if(empty($request->username)){
            return response()->json(['status' => false, 'msg' => "Vui lòng nhập số điện thoại người nhận"]);
        }else{
                
                $result = $this->Momo_getInfo($request->username);
                
                if($result && isset($result['extra']) && isset($result['extra']['NAME']) ){
                    return response()->json(['status' => true, 'name' => $result['extra']['NAME'], 'msg' => "Lấy thông tin thành công"]);
                }else{
                    return response()->json(['status' => false, 'msg' => "Số điện thoại người nhận không tồn tại"]);
                }
        }
    }
    
    public function init_pay(Request $request){
        if(empty($request->idmomo) || empty($request->sdt_to) || empty($request->amount)){
            return response()->json(['status' => false, 'msg' => "Vui lòng nhập đầy đủ thông tin"]);
        }else{
            $data_momo = Momo::find($request->idmomo)->toArray();
            $data_creattransfers = $this->Momo_creatTransfers($data_momo, $request->sdt_to, $request->amount, $request->memo);
            if ($data_creattransfers['result'] == true) {
				$id = $data_creattransfers['momoMsg']['replyMsgs']['0']['id'];
                $data_comfirm = $this->Momo_confirmTransfers($data_momo, $id);
                if ($data_comfirm['result'] == true){
                    return response()->json(['status' => true,'msg' => "Chuyển tiền thành công"]);
                }else{
                    if ($data_comfirm == "Unauthorized") {
                        return response()->json(['status' => false, 'msg' => "Tài khoản nguồn hết phiên làm việc, vui lòng thử lại sau 5 phút."]);
					} else {
					    return response()->json(['status' => false, 'msg' => !empty($data_comfirm['errorDesc']) ? $data_comfirm['errorDesc'] : "Có lỗi xảy ra vui lòng thử lại"]);
						
					}
                }
            }else{
                return response()->json(['status' => false, 'msg' => "Không phân tích được dữ liệu [PARAMS_ID_EMPTY]."]);
            }
            
        }
    }
    
    public function chuyentien(Request $request){
        $momos = Momo::all();
        return view('momo.chuyentien', compact('momos'));
    }
    
    public function autoMomo(){
        $data_momo = Momo::where('flag_auto', 1)->first()->toArray();
        $result = $this->Momo_login($data_momo);
        $data_momo = Momo::where('flag_auto', 1)->first()->toArray();
        $result = $this->Momo_History($data_momo);
        if($result && isset($result['momoMsg']) && isset($result['momoMsg']['tranList'])){
            foreach($result['momoMsg']['tranList'] as $value){
                if($value['io'] == 1) {
                    $str = $value['comment'] ?? "";
                    $cuphap = getSetting('bank_syntax');
                    $upcase = strtolower($cuphap);
                    $str= preg_replace("/".$upcase."/i", getSetting('bank_syntax'), $str);
                    $str= preg_replace('!\s+!', ' ', $str);
        
                    $index = strpos($str,$cuphap);
                    if(preg_match('/'.$cuphap.' ([0-9]{0,})/', $str, $matches)){
                        $user_id = $matches[1];
                        $vnd = (int)$value['amount'];
                        $check_exit = HistoryBank::where('trans_id', "MOMO-".$value['tranId'])->first();
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
                                    'trans_id' => "MOMO-".$value['tranId'],
                                    'coin' => $total_dep,
                                    'memo' => "MOMO-".$value['tranId']." : " . $value['comment'],
                                    'type' => 'Nạp tiền từ MOMO',
                                ]);
                                //cong afff
                                if(!empty($updateUser->master_user_id)){
                                    $masterUser = User::find($updateUser->master_user_id);
                                    if($masterUser){
                                        $aff_rate = getSetting('aff_rate') ?? 15;
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

    public function get_rkey($length) {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $size = strlen($chars);
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }
        return $str;
    }
    
    public function encryptDecrypt($data, $key, $mode = 'ENCRYPT') {
        if (strlen($key) < 32) {
            $key = str_pad($key, 32, 'x');
        }
        $key = substr($key, 0, 32);
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        if ($mode === 'ENCRYPT') {
            return base64_encode(openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv));
        } else {
            return openssl_decrypt(base64_decode($data), 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        }
    }
    
    public function get_RSAencrypt($public_key) {
        $rsa = new RSA();
        $rsa->setEncryptionMode(\phpseclib\Crypt\RSA::ENCRYPTION_PKCS1);
        $rsa->loadKey($public_key);
        $requestkey = base64_encode($rsa->encrypt($this->config['momo_key']));
        return $requestkey;
    }
    public function get_microtime() {
        return floor(microtime(true) * 1000);
    }
    public function get_checksum($data_momo, $type) {
        $microtime = $this->get_microtime();
        $checkSumSyntax = $data_momo['username'] . $microtime . '000000' . $type . ($microtime / 1000000000000.0) . 'E12';
        return $this->encryptDecrypt($checkSumSyntax, $this->encryptDecrypt($data_momo['setupkey'], $data_momo['ohash'], 'DECRYPT'));
    }
    public function get_pHash($data_momo) {
        $pHashSyntax = $data_momo['imei'] . '|' . $data_momo['password'];
        return $this->encryptDecrypt($pHashSyntax, $this->encryptDecrypt($data_momo['setupkey'], $data_momo['ohash'], 'DECRYPT'));
    }
    public function get_imei() {
        $time = md5($this->get_microtime());
        $text = substr($time, 0, 8) . '-';
        $text .= substr($time, 8, 4) . '-';
        $text .= substr($time, 12, 4) . '-';
        $text .= substr($time, 16, 4) . '-';
        $text .= substr($time, 17, 12);
        $text = strtoupper($text);
        return $text;
    }
    
    public function get_onesignal() {
        $time = md5($this->get_microtime() + time());
        $text = substr($time, 0, 8) . '-';
        $text .= substr($time, 8, 4) . '-';
        $text .= substr($time, 12, 4) . '-';
        $text .= substr($time, 16, 4) . '-';
        $text .= substr($time, 17, 12);
        return $text;
    }
    
    public function curl_momo($data_curl) {
        $data_curl['method'] = (!empty($data_curl['method'])) ? $data_curl['method'] : "POST";
        if ($data_curl['encrypt'] == true) {
            $data_curl['data_body'] = $this->encryptDecrypt(json_encode($data_curl['data_body']), $this->config['momo_key'], "ENCRYPT");
        }
        $curl = new \Curl\Curl();
        $curl->setHeaders($data_curl['header']);
        if ($data_curl['method'] == "POST") {
            $curl->post($data_curl['url'], $data_curl['data_body']);
        }
        if ($data_curl['method'] == "GET") {
            $curl->get($data_curl['url'], $data_curl['data_body']);
        }
        
        if (empty($curl->response)) {
            return $curl->getHttpStatusCode();
        }
        $response = $curl->response;
        $encrypted = $curl->responseHeaders['encrypted'];
        if ($encrypted == true || $encrypted == "true") {
            $response = $this->encryptDecrypt($response, $this->config['momo_key'], "DECRYPT");
        }
        if (gettype($response) == 'string') {
            $response = json_decode($response, true);
        } elseif (gettype($response) == "object") {
            $response = json_decode(json_encode($response), true);
        }
        return $response;
    }
    
    public function Momo_createData($username) {
        
    }
    
    public function Momo_getOtp($data_momo) {
        $microtime = $this->get_microtime();
        $return['url'] = "https://api.momo.vn/backend/otp-app/public/SEND_OTP_MSG";
        $return['encrypt'] = false;
        $return['method'] = "POST";
        $return['header'] = array(
            'User-Agent' => $this->config['momo_userAgent'],
            'Msgtype' => "SEND_OTP_MSG",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            "Accept-Language" => "vi-vn",
        );
        $return['data_body'] = array(
            'user' => $data_momo['username'],
            'msgType' => 'SEND_OTP_MSG',
            'cmdId' => "{$microtime}000000",
            'lang' => "vi",
            'channel' => "APP",
            'time' => $microtime,
            'appVer' => $this->config['momo_appVer'],
            'appCode' => $this->config['momo_appCode'],
            'deviceOS' => $this->config['momo_deviceOS'],
            'buildNumber' => 0,
            'appId' => "vn.momo.platform",
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'extra' => array(
                'action' => 'SEND',
                'rkey' => $data_momo['rkey'],
                'AAID' => '',
                'IDFA' => '',
                'TOKEN' => '',
                'ONESIGNAL_TOKEN' => $data_momo['onesignal'],
                'SIMULATOR' => 'false',
                'isVoice' => 'false',
                'REQUIRE_HASH_STRING_OTP' => false,
                'checkSum' => "",
            ),
            'momoMsg' => array(
                '_class' => 'mservice.backend.entity.msg.RegDeviceMsg',
                'number' => $data_momo['username'],
                'imei' => $data_momo['imei'],
                'cname' => 'Vietnam',
                'ccode' => '084',
                'device' => 'iPhone',
                'firmware' => '13.5.1',
                'hardware' => 'iPhone',
                'manufacture' => 'Apple',
                'csp' => 'Viettel',
                'icc' => '',
                'mcc' => '452',
                'mnc' => '04',
                'device_os' => 'IOS',
            ),
        );
        $response = $this->curl_momo($return);
        return $response;
    }
    
    public function Momo_checkOtp($data_momo, $otp) {
        $microtime = $this->get_microtime();
        $return['method'] = "POST";
        $return['url'] = "https://api.momo.vn/backend/otp-app/public/REG_DEVICE_MSG";
        $return['encrypt'] = false;
        $return['header'] = array(
            'User-Agent' => $this->config['momo_userAgent'],
            'Msgtype' => "REG_DEVICE_MSG",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            "Accept-Language" => "vi-vn",
        );
        $return['data_body'] = array(
            'user' => $data_momo['username'],
            'msgType' => "REG_DEVICE_MSG",
            'cmdId' => "{$microtime}000000",
            'lang' => "vi",
            'channel' => "APP",
            'time' => $microtime,
            'appVer' => $this->config['momo_appVer'],
            'appCode' => $this->config['momo_appCode'],
            'deviceOS' => $this->config['momo_deviceOS'],
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'extra' => [
                'ohash' => hash('sha256', $data_momo['username'] . $data_momo['rkey'] . $otp),
                'AAID' => '',
                'IDFA' => '',
                'TOKEN' => '',
                'ONESIGNAL_TOKEN' => $data_momo['onesignal'],
                'SIMULATOR' => 'false',
                'checkSum' => "",
            ],
            'momoMsg' => array(
                '_class' => 'mservice.backend.entity.msg.RegDeviceMsg',
                'number' => $data_momo['username'],
                'imei' => $data_momo['imei'],
                'cname' => 'Vietnam',
                'ccode' => '084',
                'device' => 'iPhone',
                'firmware' => '13.5.1',
                'hardware' => 'iPhone',
                'manufacture' => 'Apple',
                'csp' => 'Viettel',
                'icc' => '',
                'mcc' => '452',
                'mnc' => '04',
                'device_os' => 'IOS',
            ),
        );
    
        $response = $this->curl_momo($return);
        if (isset($response['extra']) && !empty($response['extra']['setupKey']) && !empty($response['extra']['ohash'])) {
            $momo = Momo::where('username', $data_momo['username'])->first();
            $momo->setupkey = $response['extra']['setupKey'];
            $momo->ohash = $response['extra']['ohash'];
            $momo->save();
            return true;
        }
        return false;
    }
    
    public function Momo_login($data_momo) {
        $microtime = $this->get_microtime();
        $return['method'] = "POST";
        $return['encrypt'] = false;
        $return['type'] = "class";
        $return['url'] = "https://owa.momo.vn/public/login";
        $return['header'] = array(
            'User-Agent' => $this->config['momo_userAgent'],
            'Msgtype' => "USER_LOGIN_MSG",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'accept-language' => 'vi-vn',
            'Userhash' => md5($data_momo['username']),
            'user_phone' => $data_momo['username'],
            'app_code' => $this->config['momo_appCode'],
            'app_version' => $this->config['momo_appVer'],
            'device_os' => $this->config['momo_deviceOS'],
        );
        $return['data_body'] = array(
            'user' => $data_momo['username'],
            'pass' => $data_momo['password'],
            'msgType' => 'USER_LOGIN_MSG',
            'cmdId' => "{$microtime}000000",
            'lang' => "vi",
            'channel' => "APP",
            'time' => $microtime,
            'appVer' => $this->config['momo_appVer'],
            'appCode' => $this->config['momo_appCode'],
            'deviceOS' => $this->config['momo_deviceOS'],
            'appId' => "vn.momo.platform",
            'buildNumber' => 0,
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'extra' => array(
                'checkSum' => $this->get_checksum($data_momo, 'USER_LOGIN_MSG'),
                'pHash' => $this->get_pHash($data_momo),
                'AAID' => '',
                'IDFA' => '',
                'TOKEN' => '',
                'ONESIGNAL_TOKEN' => $data_momo['onesignal'],
                'SIMULATOR' => false,
                'checkSum' => $this->get_checksum($data_momo, "USER_LOGIN_MSG"),
            ),
            'momoMsg' => array(
                '_class' => 'mservice.backend.entity.msg.LoginMsg',
                'isSetup' => false,
            ),
        );
        // $response = $this->curl_momo($return);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://owa.momo.vn/public/login",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($return['data_body']),
            CURLOPT_HTTPHEADER => $return['header'],
        ]);

        $response = curl_exec($curl);
        if (gettype($response) == 'string') {
            $response = json_decode($response, true);
        } elseif (gettype($response) == "object") {
            $response = json_decode(json_encode($response), true);
        }
        curl_close($curl);

        if (empty($response)) {
            return false;
        }
        if (!empty($response['extra']['AUTH_TOKEN'])) {
            $requestkey = $this->get_RSAencrypt($response['extra']['REQUEST_ENCRYPT_KEY']);
            $momo = Momo::where('username', $data_momo['username'])->first();
            $momo->auth_token = trim($response['extra']['AUTH_TOKEN']);
            $momo->status = 1;
            $momo->balance = $response['extra']['BALANCE'];
            $momo->requestkey = $requestkey;
            $momo->data_account = json_encode($response);
            $momo->save();
            return true;
        }
        return false;
    }
    
    public function Momo_History($data_momo, $hours = 7) {
        $microtime = $this->get_microtime();
        $return['encrypt'] = true;
        $return['method'] = "POST";
        $return['type'] = "class";
        $return['url'] = "https://owa.momo.vn/api/sync/QUERY_TRAN_HIS_MSG";
        $return['header'] = array(
            'User-Agent' => $this->config['momo_userAgent'],
            'Msgtype' => "QUERY_TRAN_HIS_MSG",
            'Userhash' => md5($data_momo['username']),
            'userid' => $data_momo['username'],
            'requestkey' => $data_momo['requestkey'],
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$data_momo['auth_token']}",
        );
        $return['data_body'] = array(
            'user' => $data_momo['username'],
            'msgType' => 'QUERY_TRAN_HIS_MSG',
            'cmdId' => "{$microtime}000000",
            'lang' => "vi",
            'channel' => "APP",
            'time' => $microtime,
            'appVer' => $this->config['momo_appVer'],
            'appCode' => $this->config['momo_appCode'],
            'deviceOS' => $this->config['momo_deviceOS'],
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'buildNumber' => 0,
            "appId" => "vn.momo.platform",
            'extra' => array(
                'checkSum' => $this->get_checksum($data_momo, "QUERY_TRAN_HIS_MSG"),
            ),
            'momoMsg' => array(
                '_class' => 'mservice.backend.entity.msg.QueryTranhisMsg',
                'begin' => (time() - (3600 * $hours)) * 1000,
                'end' => $microtime,
            ),
        );
        $response = $this->curl_momo($return);
        if ($response == 401 || $response == 400) {
            $momo = Momo::where('username', $data_momo['username'])->first();
            $momo->status = 0;
            $momo->save();
        }
        return $response;
    }
    
    public function Momo_getInfo($username) {
        $microtime = $this->get_microtime();
        $return['method'] = "POST";
        $return['type'] = "class";
        $return['encrypt'] = false;
        $return['url'] = "https://owa.momo.vn/public";
        $return['header'] = array(
            'User-Agent' => $this->config['momo_userAgent'],
            'Msgtype' => "CHECK_USER_BE_MSG",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        );
        $return['data_body'] = array(
            'user' => $username,
            'msgType' => 'CHECK_USER_BE_MSG',
            'cmdId' => "{$microtime}000000",
            'lang' => "vi",
            'channel' => "APP",
            'time' => $microtime,
            'appVer' => $this->config['momo_appVer'],
            'appCode' => $this->config['momo_appCode'],
            'deviceOS' => $this->config['momo_deviceOS'],
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'buildNumber' => 0,
            'appId' => "vn.momo.platform",
            'extra' => array(
                'checkSum' => "",
            ),
            'momoMsg' => array(
                '_class' => 'mservice.backend.entity.msg.RegDeviceMsg',
                "number" => $username,
                'imei' => $this->get_imei(),
                'cname' => 'Vietnam',
                'ccode' => '084',
                'device' => 'iPhone',
                'firmware' => '13.5.1',
                'hardware' => 'iPhone',
                'manufacture' => 'Apple',
                'csp' => 'Viettel',
                'icc' => '',
                'mcc' => '452',
                'mnc' => '04',
                'device_os' => 'IOS',
            ),
        );
        $response = $this->curl_momo($return);
        return $response;
    }
    
    public function Momo_creatTransfers($data_momo, $to_phone, $balance, $comment) {
        $microtime = $this->get_microtime();
        $return['method'] = "POST";
        $return['type'] = "class";
        $return['encrypt'] = true;
        $return['url'] = "https://owa.momo.vn/api/M2MU_INIT";
        $ip = "115.79.139.159";
        $return['header'] = array(
            'User-Agent' => $this->config['momo_userAgent'],
            'Msgtype' => 'M2MU_INIT',
            'Userhash' => md5($data_momo['username']),
            'userid' => $data_momo['username'],
            'requestkey' => $data_momo['requestkey'],
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$data_momo['auth_token']}",
        );
        $return['data_body'] = [
            'user' => $data_momo['username'],
            'msgType' => 'M2MU_INIT',
            'cmdId' => "{$microtime}000000",
            'lang' => "vi",
            'channel' => "APP",
            'time' => $microtime,
            'appVer' => $this->config['momo_appVer'],
            'appCode' => $this->config['momo_appCode'],
            'deviceOS' => $this->config['momo_deviceOS'],
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'extra' => [
                'checkSum' => $this->get_checksum($data_momo, "M2MU_INIT"),
            ],
            'momoMsg' => [
                '_class' => 'mservice.backend.entity.msg.M2MUInitMsg',
                'ref' => '',
                'tranList' => [
                    0 => [
                        '_class' => 'mservice.backend.entity.msg.TranHisMsg',
                        'tranType' => 2018,
                        'partnerId' => $to_phone,
                        'originalAmount' => $balance,
                        'comment' => $comment,
                        'moneySource' => 1,
                        'partnerCode' => 'momo',
                        'partnerName' => "",
                        'rowCardId' => NULL,
                        'serviceMode' => 'transfer_p2p',
                        'serviceId' => 'transfer_p2p',
                        'extras' => json_encode(
                            array(
                                "vpc_CardType" => "SML",
                                "vpc_TicketNo" => $ip,
                                "receiverMembers" => array(
                                    "receiverNumber" => $to_phone,
                                    "receiverName" => "",
                                    "originalAmount" => $balance,
                                ),
                                "loanId" => 0,
                                "contact" => array(),
                            )
                        ),
                    ],
                ],
            ],
        ];
        $response = $this->curl_momo($return);
        if ($response == "Unauthorized" || $response == 401) {
            $momo = Momo::where('username', $data_momo['username'])->first();
            $momo->status = 0;
            $momo->save();
        }
        return $response;
    }
    
    public function Momo_confirmTransfers($data_momo, $id) {
        $microtime = $this->get_microtime();
        $return['method'] = "POST";
        $return['type'] = "class";
        $return['encrypt'] = true;
        $return['url'] = "https://owa.momo.vn/api/M2MU_CONFIRM";
        $return['header'] = array(
            'User-Agent' => $this->config['momo_userAgent'],
            'Msgtype' => 'M2MU_CONFIRM',
            'Userhash' => md5($data_momo['username']),
            'userid' => $data_momo['username'],
            'Accept' => 'application/json',
            'requestkey' => $data_momo['requestkey'],
            'accept-language' => 'vi-vn',
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$data_momo['auth_token']}",
        );
        $return['data_body'] = [
            'user' => $data_momo['username'],
            'msgType' => 'M2MU_CONFIRM',
            'cmdId' => "{$microtime}000000",
            'lang' => "vi",
            'channel' => "APP",
            'time' => $microtime,
            'appVer' => $this->config['momo_appVer'],
            'appCode' => $this->config['momo_appCode'],
            'deviceOS' => $this->config['momo_deviceOS'],
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'extra' => [
                'checkSum' => $this->get_checksum($data_momo, "M2MU_CONFIRM"),
            ],
            'momoMsg' => [
                'ids' => [
                    0 => $id,
                ],
                'bankInId' => '',
                '_class' => 'mservice.backend.entity.msg.M2MUConfirmMsg',
                'otp' => '',
                'otpBanknet' => '',
                'extras' => '',
            ],
            'pass' => $data_momo['password'],
        ];
    
        $response = $this->curl_momo($return);
        if ($response == "Unauthorized" || $response == 401) {
            $momo = Momo::where('username', $data_momo['username'])->first();
            $momo->status = 0;
            $momo->save();
        }
        return $response;
    }
    
    public function Momo_listBank($data_momo) {$return['method'] = "POST";
        $return['type'] = "class";
        $return['url'] = "https://owa.momo.vn/service";
        $return['encrypt'] = true;
        $return['data_body'] = [
            'requestId' => get_onesignal(),
            'agent' => $data_momo['username'],
            'msgType' => "NapasBankCodeRequestMsg",
            'serviceId' => "2001",
            'source' => 2,
    
        ];
    
        $return['header'] = array(
            'User-Agent' => $this->config['momo_userAgent'],
            'msgtype' => "NapasBankCodeRequestMsg",
            'userhash' => md5($data_momo['username']),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'userid' => $data_momo['username'],
            'requestkey' => $data_momo['requestkey'],
            'accept-language' => 'vi-vn',
            'Authorization' => "Bearer {$data_momo['auth_token']}",
        );
        $response = $this->curl_momo($return);
        if (empty($response)) {
            $data['status'] = 500;
            $data['message'] = "empty_response";
        }
        return $response;
    }
    
    public function Momo_checkBank($data_momo, $bank, $accId) {$return['method'] = "POST";
        $return['type'] = "class";
        $return['url'] = "https://owa.momo.vn/service";
        $return['encrypt'] = true;
        $return['data_body'] = [
            'requestId' => get_onesignal(),
            'agent' => $data_momo['username'],
            'msgType' => "CheckAccountRequestMsg",
            'coreBankCode' => "2001",
            'serviceId' => "2001",
            'source' => 2,
            'channel' => "APP",
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'benfAccount' => [
                "accId" => $accId,
                "napasBank" => [
                    "bankCode" => $bank['bankCode'],
                    "bankName" => $bank['bankName'],
                ],
            ],
    
        ];
    
        $return['header'] = array(
            'User-Agent' => $this->config['momo_userAgent'],
            'msgtype' => "CheckAccountRequestMsg",
            'userhash' => md5($data_momo['username']),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'userid' => $data_momo['username'],
            'requestkey' => $data_momo['requestkey'],
            'accept-language' => 'vi-vn',
            'Authorization' => "Bearer {$data_momo['auth_token']}",
        );
        $response = $this->curl_momo($return);
        if ($response == "Unauthorized" || $response == 401) {
            $db->where("username", $data_momo['username'])->update("momo_account", array("status" => 0));
        }
        return $response;
    }
    
    public function Momo_creatTransfersOutMomo($data_momo, $bank, $CardNum, $CardName, $amount, $partnerRef, $comment) {
        $microtime = $this->get_microtime();
        $ip = get_ip_address();
        $ip = $ip ? $ip : "115.79.139.159";
        $return['method'] = "POST";
        $return['type'] = "class";
        $return['encrypt'] = true;
        $return['url'] = "https://owa.momo.vn/api/TRAN_HIS_INIT_MSG/8/transfer_p2b";
        $return['header'] = array(
            'User-Agent' => $this->config['momo_userAgent'],
            'Msgtype' => "TRAN_HIS_INIT_MSG",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Userhash' => md5($data_momo['username']),
            'userid' => $data_momo['username'],
            'requestkey' => $data_momo['requestkey'],
            'accept-language' => 'vi-vn',
            'Authorization' => "Bearer {$data_momo['auth_token']}",
        );
        $return['data_body'] = [
            'user' => $data_momo['username'],
            'msgType' => 'TRAN_HIS_INIT_MSG',
            'cmdId' => "{$microtime}000000",
            'lang' => "vi",
            'channel' => "APP",
            'time' => $microtime,
            'appVer' => $this->config['momo_appVer'],
            'appCode' => $this->config['momo_appCode'],
            'deviceOS' => $this->config['momo_deviceOS'],
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'extra' => [
                'checkSum' => get_checksum($data_momo, 'TRAN_HIS_INIT_MSG'),
            ],
            'momoMsg' => [
                'user' => $data_momo['username'],
                'clientTime' => $microtime,
                'tranType' => 8,
                'comment' => $comment,
                'amount' => $amount,
                'moneySource' => 1,
                'partnerCode' => 'momo',
                'partnerId' => $bank['bankCode'],
                'partnerName' => $bank['bankName'],
                'serviceId' => "transfer_p2b",
                'rowCardNum' => $CardNum,
                'rowCardId' => null,
                'ownerName' => $CardName,
                'partnerRef' => $partnerRef,
                'extras' => json_encode(
                    array(
                        "bankName" => $bank['shortBankName'],
                        "bankLinkImage" => 139,
                        "bankNumber" => $CardNum,
                        "saveCard" => false,
                        "vpc_CardType" => "SML",
                        "vpc_TicketNo" => $ip,
                    )
                ),
                '_class' => 'mservice.backend.entity.msg.TranHisMsg',
                'giftId' => "",
            ],
        ];
    
        $response = $this->curl_momo($return);
        if ($response == "Unauthorized" || $response == 401) {
            $db->where("username", $data_momo['username'])->update("momo_account", array("status" => 0));
        }
        return $response;
    }
    
    public function Momo_confirmTransfersOutMomo($data_momo, $id, $bank, $CardNum, $CardName, $amount, $fee, $partnerRef, $comment, $extras) {
        $microtime = $this->get_microtime();
        $return['method'] = "POST";
        $return['type'] = "class";
        $return['encrypt'] = true;
        $return['url'] = "https://owa.momo.vn/api/TRAN_HIS_CONFIRM_MSG/8/transfer_p2b";
        $return['header'] = array(
            'User-Agent' => $this->config['momo_userAgent'],
            'Msgtype' => "TRAN_HIS_CONFIRM_MSG",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Userhash' => md5($data_momo['username']),
            'userid' => $data_momo['username'],
            'requestkey' => $data_momo['requestkey'],
            'accept-language' => 'vi-vn',
            'Authorization' => "Bearer {$data_momo['auth_token']}",
        );
        $return['data_body'] = [
            'user' => $data_momo['username'],
            'msgType' => 'TRAN_HIS_CONFIRM_MSG',
            'cmdId' => "{$microtime}000000",
            'lang' => "vi",
            'channel' => "APP",
            'time' => $microtime,
            'appVer' => $this->config['momo_appVer'],
            'appCode' => $this->config['momo_appCode'],
            'deviceOS' => $this->config['momo_deviceOS'],
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'extra' => [
                'checkSum' => get_checksum($data_momo, 'TRAN_HIS_CONFIRM_MSG'),
                "cvn" => "",
            ],
            'momoMsg' => [
                "ID" => $id,
                'user' => $data_momo['username'],
                "commandInd" => "{$microtime}000000",
                'tranId' => $microtime,
                'clientTime' => $microtime,
                'ackTime' => $microtime,
                'tranType' => 8,
                'io' => -1,
                'partnerId' => $bank['bankCode'],
                'partnerCode' => 'momo',
                'partnerName' => $bank['bankName'],
                'partnerRef' => $partnerRef,
                'amount' => intval($amount),
                'comment' => $comment,
                'status' => 4,
                'ownerNumber' => $data_momo['username'],
                'ownerName' => $CardName,
                'moneySource' => 1,
                'desc' => "Thành Công",
                'fee' => $fee,
                'originalAmount' => $amount - $fee,
                'serviceId' => "transfer_p2b",
                "quantity" => 1,
                "lastUpdate" => $microtime,
                "share" => "0.0",
                "receiverType" => 2,
                'extras' => json_encode($extras),
                "rowCardNum" => $CardNum,
                '_class' => 'mservice.backend.entity.msg.TranHisMsg',
                "channel" => "END_USER",
                "otpType" => "NA",
            ],
            "pass" => $data_momo['password'],
        ];
    
        $response = $this->curl_momo($return);
        if ($response == "Unauthorized" || $response == 401) {
            $db->where("username", $data_momo['username'])->update("momo_account", array("status" => 0));
        }
        return $response;
    }
}
