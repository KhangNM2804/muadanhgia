<?php

namespace App\Console\Commands;

use App\Models\HistoryBank;
use App\Models\User;
use Illuminate\Console\Command;

class autoVCB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:autovcb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $flag_auto_vcb = getSetting('flag_auto_vcb');
        if ($flag_auto_vcb == "on") {

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
    }
}
