<?php

namespace App\Http\Controllers;

use App\Models\HistoryBank;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BankController extends Controller
{
    public function endpoint_tcb(){
        $token = getSetting('token_tcb');
        $raw = file_get_contents('php://input');

        $transaction = json_decode($raw);

        if (json_last_error() != JSON_ERROR_NONE) {
            exit;
        }

        $getToken = $this->getHeader('X-THUEAPI');

        if (empty($getToken) || $token != $getToken) {
            exit;
        }

        if (empty($transaction->txn_id)) {
            exit;
        }

        $str = $transaction->content;
        $str = str_replace(' ', '', $str);
        $cuphap = getSetting('bank_syntax');
        $upcase = strtolower($cuphap);
        $str= preg_replace("/".$upcase."/i", getSetting('bank_syntax'), $str);
        $str= preg_replace('!\s+!', ' ', $str);

        $index = strpos($str,$cuphap);
        if(preg_match('/'.$cuphap.'([0-9]{0,})/', $str, $matches)){
            $user_id = $matches[1];
            $vnd = (int)str_replace(',', '',$transaction->money);
            $txn_id = $transaction->txn_id;
            if (preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2})-([0-9]{0,})/', $transaction->txn_id, $matches_txnid)){
                $txn_id = $matches_txnid[4];
            }
            $check_exit = HistoryBank::where('trans_id', 'LIKE', '%' . $txn_id . '%')->first();
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
                        'trans_id' => (string)$transaction->txn_id,
                        'coin' => $total_dep,
                        'memo' => $transaction->content,
                        'type' => 'Nạp tiền từ Techcombank'
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

    public function endpoint_mb(){
        $token = getSetting('token_mb');
        $raw = file_get_contents('php://input');

        $transaction = json_decode($raw);

        if (json_last_error() != JSON_ERROR_NONE) {
            exit;
        }

        $getToken = $this->getHeader('X-THUEAPI');

        if (empty($getToken) || $token != $getToken) {
            exit;
        }

        if (empty($transaction->txn_id)) {
            exit;
        }

        $str = $transaction->content;
        $str = str_replace(' ', '', $str);
        $cuphap = getSetting('bank_syntax');
        $upcase = strtolower($cuphap);
        $str= preg_replace("/".$upcase."/i", getSetting('bank_syntax'), $str);
        $str= preg_replace('!\s+!', ' ', $str);

        $index = strpos($str,$cuphap);
        if(preg_match('/'.$cuphap.'([0-9]{0,})/', $str, $matches)){
            $user_id = $matches[1];
            $vnd = (int)str_replace(',', '',$transaction->money);
            $check_exit = HistoryBank::where('trans_id', $transaction->txn_id)->first();
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
                        'trans_id' => (string)$transaction->txn_id,
                        'coin' => $total_dep,
                        'memo' => $transaction->content,
                        'type' => 'Nạp tiền từ MB Bank'
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
    public function endpoint_vietinbank(){
        $token = getSetting('token_vietinbank');
        $raw = file_get_contents('php://input');

        $transaction = json_decode($raw);

        if (json_last_error() != JSON_ERROR_NONE) {
            exit;
        }

        $getToken = $this->getHeader('X-THUEAPI');

        if (empty($getToken) || $token != $getToken) {
            exit;
        }

        if (empty($transaction->txn_id)) {
            exit;
        }

        $str = $transaction->content;
        $str = str_replace(' ', '', $str);
        $cuphap = getSetting('bank_syntax');
        $upcase = strtolower($cuphap);
        $str= preg_replace("/".$upcase."/i", getSetting('bank_syntax'), $str);
        $str= preg_replace('!\s+!', ' ', $str);

        $index = strpos($str,$cuphap);
        if(preg_match('/'.$cuphap.'([0-9]{0,})/', $str, $matches)){
            $user_id = $matches[1];
            $vnd = (int)str_replace(',', '',$transaction->money);
            $check_exit = HistoryBank::where('trans_id', $transaction->txn_id)->first();
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
                        'trans_id' => (string)$transaction->txn_id,
                        'coin' => $total_dep,
                        'memo' => $transaction->content,
                        'type' => 'Nạp tiền từ Vietinbank'
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

    public function getHeader($header)
    {
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
            if (str_replace(' ', '-', ucwords(str_replace('_', ' ', substr($name, 5)))) == $header)
                return $value;
            }
        }

        return false;
    }
}
