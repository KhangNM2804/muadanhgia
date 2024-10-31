<?php

namespace App\Http\Controllers;

use App\Exports\ExportListUser;
use App\Exports\ExportTotalBuy;
use App\Exports\ExportTotalDeposit;
use App\Models\Category;
use App\Models\HistoryBank;
use App\Models\HistoryBuy;
use App\Models\ListSelled;
use App\Models\Login;
use App\Models\Momo;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public function index(Request $request){
        $name = $request->name;
        $types = Type::with('allCategory')->whereHas('allCategory', function ($query) use ($name) {
            $query->where('name', 'LIKE','%'.$name.'%');
        })->where('display',1)->orderBy('sort_num')->orderBy('id')->get();
        $getHistoryBuy = HistoryBuy::orderBy('created_at','desc')->take(13)->get();
        $getHistoryBank= HistoryBank::orderBy('created_at','desc')->take(13)->get();
        $posts = Post::where('public',1)->where('pin',1)->orderby('id','DESC')->get();
        return view('dashboard.index', compact(
            'getHistoryBuy',
            'getHistoryBank',
            'posts',
            'types'
        ));
    }

    public function muahang(Request $request,$id){
        $types = Type::find($id)->toArray();
        abort_if(!empty($type),404);
        if($types){
            $types['listcate'] = Category::getListByType($id,$request->name);
        }
        $getHistoryBuy = HistoryBuy::orderBy('created_at','desc')->take(13)->get();
        $getHistoryBank= HistoryBank::orderBy('created_at','desc')->take(13)->get();
        $posts = Post::where('public',1)->where('pin',1)->orderby('id','DESC')->get();
        return view('dashboard.muahang', compact(
            'getHistoryBuy',
            'getHistoryBank',
            'posts',
            'types'
        ));
    }

    public function muamail(){
        $listMail = Category::getListByType(4);
        $getHistoryBuy = HistoryBuy::orderBy('created_at','desc')->take(5)->get();
        $getHistoryBank= HistoryBank::orderBy('created_at','desc')->take(5)->get();
        return view('dashboard.muamail', compact(
            'listMail',
            'getHistoryBuy',
            'getHistoryBank',
        ));
    }

    public function listUser(Request $request){
        $users = User::orderBy('coin','desc')
        ->when($request->username, function ($query) use ($request) {
            $query->where('username', 'LIKE','%'.$request->username.'%');
        })
        ->when($request->phone, function ($query) use ($request) {
            $query->where('phone', 'LIKE','%'.$request->phone.'%');
        })
        ->when($request->ip, function ($query) use ($request) {
            $query->where('last_ip', $request->ip);
        })
        ->paginate(15);
        $users_aff = User::where('aff_flg',1)->get();
        return view('dashboard.list_user', compact('users','users_aff'));
    }

    
    public function lichsunap(){
        $user = Auth::user();
        $gethistory = HistoryBank::where('user_id',$user->id)->orderBy('created_at','desc')->get();
        return view('dashboard.lichsunap', compact(
            'gethistory'
        ));
    }

    public function hotro(){
        return view('dashboard.hotro');
    }

    public function setting(){
        $client = new \GuzzleHttp\Client();
        $result_vcb = null;
        $result_acb = null;
        $result_mb = null;
        $result_vtb = null;
        $user_vcb = getSetting('bank_user');
        $user_acb = getSetting('bank_user_acb');
        $user_mb = getSetting('bank_user_mb');
        $user_vietinbank = getSetting('bank_user_vietinbank');
        if ($user_vcb) {
            $check_auto_vcb = $client->request("GET", "https://api.vnitshare.com/api/check/vcb/".$user_vcb);
            $result_vcb = json_decode($check_auto_vcb->getBody());
        }
        if ($user_acb) {
            $check_auto_acb = $client->request("GET", "https://api.vnitshare.com/api/check/acb/".$user_acb);
            $result_acb = json_decode($check_auto_acb->getBody());
        }
        if ($user_mb) {
            $check_auto_mb = $client->request("GET", "https://api.vnitshare.com/api/check/mb/".$user_mb);
            $result_mb = json_decode($check_auto_mb->getBody());
        }
        if ($user_vietinbank) {
            $check_auto_vtb = $client->request("GET", "https://api.vnitshare.com/api/check/vtb/".$user_vietinbank);
            $result_vtb = json_decode($check_auto_vtb->getBody());
        }
        
        return view('dashboard.setting', compact('result_vcb', 'result_acb', 'result_mb', 'result_vtb'));
    }
    
    public function setting_telegram(){
        return view('dashboard.setting_telegram');
    }

    public function post_setting_telegram(Request $request){
        $dataInput = $request->all();
        if($dataInput){
            unset($dataInput['_token']);
            foreach ($dataInput as $key => $value) {
                $getSetting = Setting::where('cd_key',$key)->first();
                if(!empty($getSetting)){
                    $getSetting->cd_value = $value;
                    $getSetting->save();
                }else{
                    Setting::create([
                        'cd_key' => $key,
                        'cd_value' => $value,
                    ]);
                }
            }
        }
        return redirect()->route('setting_telegram');
    }

    public function buy_all(Request $request){

        $user = Auth::user();
        $getHistoryBuy = HistoryBuy::orderBy('created_at','desc')
                        ->when($request->id, function ($query) use ($request) {
                            $query->where('id',$request->id);
                        })
                        ->when($request->uid, function ($query) use ($request) {
                            $arr_uid = explode("\r\n",$request->uid);
                            $list_selled = ListSelled::whereIn('uid', $arr_uid)->pluck('buy_id')->toArray();
                            $query->whereIn('id', $list_selled);
                       })
                        ->when($request->username, function ($query) use($request) {
                            $query->whereHas('getuser',function($q) use ($request){
                                                $q->where('username', 'LIKE','%'.$request->username.'%');
                                            });
                        })
                        ->when($request->phone, function ($query) use($request) {
                            $query->whereHas('getuser',function($q) use ($request){
                                                $q->where('phone', $request->phone);
                                            });
                        })
                        ->withTrashed()
                        ->paginate(10);
        return view('dashboard.buy_all',compact('getHistoryBuy'));
    }

    public function deposit_all(Request $request){

        $gethistory = HistoryBank::orderBy('created_at','desc')
                                        ->when($request->trans_id, function ($query) use ($request) {
                                            $query->where('trans_id',$request->trans_id);
                                        })
                                        ->when($request->username, function ($query) use($request) {
                                            $query->whereHas('getuser',function($q) use ($request){
                                                                $q->where('username', 'LIKE','%'.$request->username.'%');
                                                            });
                                        })
                                        ->paginate(10);
        $total_subday = HistoryBank::whereDate('created_at', Carbon::yesterday())->get()->sum('coin');
        $total_date = HistoryBank::whereDate('created_at', Carbon::today())->get()->sum('coin');
        $total_week = HistoryBank::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->sum('coin');
        $total_month = HistoryBank::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get()->sum('coin');
        $top_deposit_month = HistoryBank::groupBy('user_id')->select('user_id',DB::raw('sum(coin) as total'))
        ->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))
        ->whereHas('getuser',function($q){
            $q->where('role', '!=',1);
        })
        ->orderBy('total','DESC')->limit(10)->get();
        return view('dashboard.deposit_all', compact(
            'gethistory',
            'total_date',
            'total_week',
            'total_month',
            'total_subday',
            'top_deposit_month'
        ));
    }

    public function doanhthu_chart(){
        $deposit_month = HistoryBank::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get()->sum('coin');
        $buy_month = HistoryBuy::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get()->sum('total_price');
        return view('dashboard.doanhthu_chart', compact('deposit_month','buy_month'));
    }
    public function get_chart(Request $request){
        if($request->type == "week"){
            $deposit = HistoryBank::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->sum('coin');
            $buy = HistoryBuy::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->sum('total_price');
        }
        if($request->type == "month"){
            $deposit = HistoryBank::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get()->sum('coin');
            $buy = HistoryBuy::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get()->sum('total_price');
        }
        if($request->type == "year"){
            $deposit = HistoryBank::whereYear('created_at', date('Y'))->get()->sum('coin');
            $buy = HistoryBuy::whereYear('created_at', date('Y'))->get()->sum('total_price');
        }
        if($request->type == "date_range"){
            if(!empty($request->from) && !empty($request->to)){
                $deposit = HistoryBank::whereDate('created_at', '>=',Carbon::parse($request->from)->format("Y-m-d"))
                ->whereDate('created_at', '<=',Carbon::parse($request->to)->format("Y-m-d"))->get()->sum('coin');
                $buy = HistoryBuy::whereDate('created_at', '>=',Carbon::parse($request->from)->format("Y-m-d"))
                ->whereDate('created_at', '<=',Carbon::parse($request->to)->format("Y-m-d"))->get()->sum('total_price');
            }else{
                return response()->json(['status' => false, 'msg' => 'Vui lòng nhập ngày bắt đầu và ngày kết thúc']);
            }
        }
        $data = [
            $deposit,
            $buy,
            $deposit - $buy,
        ];
        
        if(array_sum($data) == 0){
            return response()->json(['status' => false, 'msg' => 'Không có dữ liệu']);
        }
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function export_deposit_excel(Request $request){
        if(!empty($request->from) && !empty($request->to)){

            $list_users = User::with(['historybank' => function($q) use($request){
                $q->whereDate('created_at', '>=',Carbon::parse($request->from)->format("Y-m-d"))
                    ->whereDate('created_at', '<=',Carbon::parse($request->to)->format("Y-m-d"));
            }])->get();

            $filename = "TongNap_".Carbon::parse($request->from)->format("Y-m-d"). '_' .  Carbon::parse($request->to)->format("Y-m-d"). '.xlsx';
            Excel::store(new ExportTotalDeposit($list_users), $filename);
            
            return response()->json(['status' => true, 'filename' => $filename]);
        }else{
            return response()->json(['status' => false, 'msg' => 'Vui lòng nhập ngày bắt đầu và ngày kết thúc']);
        }

    }

    public function export_buy_excel(Request $request){
        if(!empty($request->from) && !empty($request->to)){

            $list_users = User::with(['historybuy' => function($q) use($request){
                $q->whereDate('created_at', '>=',Carbon::parse($request->from)->format("Y-m-d"))
                    ->whereDate('created_at', '<=',Carbon::parse($request->to)->format("Y-m-d"));
            }])->get();

            $filename = "TongBuy".Carbon::parse($request->from)->format("Y-m-d"). '_' .  Carbon::parse($request->to)->format("Y-m-d"). '.xlsx';
            Excel::store(new ExportTotalBuy($list_users), $filename);
            
            return response()->json(['status' => true, 'filename' => $filename]);
        }else{
            return response()->json(['status' => false, 'msg' => 'Vui lòng nhập ngày bắt đầu và ngày kết thúc']);
        }

    }
    
    public function download_export($filename){
        $filename_temp1 = storage_path().'/'.'app'.'/'.$filename;
        if (file_exists($filename_temp1)) {
            return response()->download($filename_temp1);
        }else{
            abort(404);
        }
    }

    public function user_export_excel(){
        $list_users = User::all();

        $filename = "Danhsach_khachhang_".Carbon::now()->format("Y-m-d").'.xlsx';
        return Excel::download(new ExportListUser($list_users), $filename)->deleteFileAfterSend(true);
    }

    public function addcoin(){
        $allUser = User::all();
        return view('dashboard.addcoin', compact(
            'allUser'
        ));
    }

    public function post_addcoin(Request $request){
        $dataInput = $request->all();
        if(empty($dataInput['user_id'])){
            abort(404);
        }else{
            try {
                DB::beginTransaction();
                $getUser = User::find($dataInput['user_id']);
                $getUser->coin += $dataInput['coin'];
                $getUser->total_coin += $dataInput['coin'];
                $getUser->save();
                HistoryBank::create([
                    'user_id' => $dataInput['user_id'],
                    'trans_id' => $dataInput['trans_id'],
                    'coin' => $dataInput['coin'],
                    'memo' => $dataInput['memo'],
                    'type' => 'Nạp tiền từ Admin',
                    'admin_id' => Auth::user()->id,
                ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('deposit_all');
            }

        }
        return redirect()->route('deposit_all');
    }

    public function post_setting(Request $request){
        $dataInput = $request->all();
        if($dataInput){
            unset($dataInput['_token']);
            foreach ($dataInput as $key => $value) {
                $getSetting = Setting::where('cd_key',$key)->first();
                if(!empty($getSetting)){
                    $getSetting->cd_value = $value;
                    $getSetting->save();
                }else{
                    Setting::create([
                        'cd_key' => $key,
                        'cd_value' => $value,
                    ]);
                }
            }
        }
        return redirect()->route('setting');
    }

    public function checkliveuid(Request $request){
        return view('dashboard.checkliveuid');
    }

    public function checkbm(Request $request){
        return view('dashboard.checkbm');
    }

    public function checkbmxmdt(Request $request){
        return view('dashboard.checkbmxmdt');
    }
    public function tool2fa(Request $request){
        return view('dashboard.2fa');
    }

    public function apicheckbm(Request $request){
        $bmid = $request->bmid;
        $token_bm = getSetting('token_bm');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => 'https://graph.facebook.com/'.$bmid.'?access_token='.$token_bm.'&_index=0&_reqName=object%3Abrand&_reqSrc=BrandResourceRequests.brands&date_format=U&fields=%5B%22id%22%2C%22name%22%2C%22vertical_id%22%2C%22timezone_id%22%2C%22picture.type(square)%22%2C%22primary_page.fields(name%2C%20picture%2C%20link)%22%2C%22payment_account_id%22%2C%22link%22%2C%22created_time%22%2C%22created_by.fields(name)%22%2C%22updated_time%22%2C%22updated_by.fields(name)%22%2C%22extended_updated_time%22%2C%22two_factor_type%22%2C%22allow_page_management_in_www%22%2C%22eligible_app_id_for_ami_initiation%22%2C%22verification_status%22%2C%22sharing_eligibility_status%22%2C%22can_create_ad_account%22%2C%22is_business_verification_eligible%22%2C%22is_non_discrimination_certified%22%5D&locale=es_LA&method=get&pretty=0&suppress_http_code=1',
            CURLOPT_SSL_VERIFYPEER => true
        ));
        $resp = curl_exec($curl);
        $res = json_decode($resp,true);
        curl_close($curl);
        if(isset($res['error']['message'])){
            return response()->json(['error' => $res['error']['message']]);
        }
        if(isset($res['allow_page_management_in_www'])){
            if($res['allow_page_management_in_www'] == false){
                return response()->json(['status' => false]);
            }elseif($res['allow_page_management_in_www'] == true){
                if(isset($res['sharing_eligibility_status']) && $res['sharing_eligibility_status'] == "enabled"){
                    return response()->json(['status' => true, "limit" => 350, "name" => $res['name']]);
                }else{
                    return response()->json(['status' => true, "limit" => 50, "name" => $res['name']]);
                }

            }
        }

    }

    public function apicheckbmxmdt(Request $request){
        try {
            $bmid = $request->bmid;
            $token_bm = getSetting('token_bm');

            $res = json_decode(file_get_contents("https://graph.facebook.com/v5.0/".addslashes(trim($bmid))."/?access_token=".$token_bm."&fields=is_disabled_for_integrity_reasons,verification_status,sharing_eligibility_status,can_create_ad_account&format=json"), true);
            if(isset($res['error']['message'])){
                return response()->json(['error' => $res['error']['message']]);
            }
            if(isset($res['verification_status'])){
                if($res['verification_status'] == 'verified'){
                    return response()->json(['status' => true]);
                }else{
                    return response()->json(['status' => false]);  
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error']);
        }

    }

    public function baiviet()
    {
        $posts = Post::where('public',1)->orderby('id','DESC')->paginate(15);

        return view('dashboard.baiviet', compact('posts'));
    }

    public function setting_api()
    {
        $user = Auth::user();
        return view('dashboard.setting_api', compact('user'));
    }

    public function updateAPIKEY(){
        $user = Auth::user();
        $user->api_key = md5($user->username.uniqid().time());
        $user->save();
        return response()->json(['status' => true, "api_key" => $user->api_key]);
    }

    public function login_history(){
        $logins = Login::orderBy('created_at', 'DESC')->paginate(20);
        return view('dashboard.login_history', compact(
            'logins'
        ));
    }

}