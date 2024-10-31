<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePassRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Category;
use App\Models\User;
use App\Models\HistoryBank;
use App\Models\HistoryBuy;
use App\Models\Login;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function username()
    {
        return 'username';
    }

    public function login(Request $request){
        $types = Type::with('allCategory')->whereHas('allCategory')->where('display',1)->orderBy('sort_num')->orderBy('id')->get();
        $getHistoryBuy = HistoryBuy::orderBy('created_at','desc')->take(13)->get();
        $getHistoryBank= HistoryBank::orderBy('created_at','desc')->take(13)->get();
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('auth.login', compact(
            'getHistoryBuy',
            'getHistoryBank',
            'types',
        ));
    }

    public function register(Request $request){
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        $getMaster = "";
        if($request->aff){
            $getMaster = User::find($request->aff);
            if(!empty($getMaster)){
                if($getMaster->aff_flg != 1){
                    echo "Lỗi! link giới thiệu không tồn tại"; exit;
                }
            }else{
                echo "Lỗi! link giới thiệu không tồn tại"; exit;
            }
        }
        return view('auth.register', compact('getMaster'));
    }

    public function logout(){
        Auth::logout();
        session(["2fa_verified" => false]);
        return redirect()->route("get.login");
    }

    public function postLogin(LoginRequest $request){
        $count_user_ip = Login::where('ip_address', $request->ip())->where('type', 'auth')->groupBy('user_id')->selectRaw('user_id, count(user_id) as total')->pluck('user_id')->toArray();
        $limit_login_ip = getSetting('limit_login_ip') != "" ? getSetting('limit_login_ip') : 0;
        $data = [
            'username' => $request->get("username"),
            'password' => $request->get("password"),
        ];

        $remember = $request->has('remember') ? true : false;
        $exits_user = User::where('username', $request->get("username"))->first();
        if($exits_user) {
            if ($exits_user->is_band) {
                return redirect()->route("get.login")->with('login_fail','Tài khoản đã bị khoá! Vui lòng liên hệ admin để được hỗ trợ');
            }
        }

        if (Auth::attempt($data,$remember)) {
            $user = Auth::user();
            if ($limit_login_ip > 0 && count($count_user_ip) >= $limit_login_ip && !in_array($user->id, $count_user_ip)) {
                Auth::logout();
                session(["2fa_verified" => false]);
                return redirect()->route("get.login")->with('login_fail','Giới hạn login 3 tài khoản trên 1 IP');
            }
            $getUser = User::find($user->id);
            $getUser->last_ip = $request->ip();
            $getUser->fail_login = 0;
            $getUser->save();
            return redirect()->route('dashboard');
        } else {
            if ($exits_user) {
                $exits_user->fail_login += 1;
                if ($exits_user->fail_login >= 5) {
                    $exits_user->is_band = 1;
                }
                $exits_user->save();
                return redirect()->route("get.login")->with('login_fail','Bạn đã đăng nhập sai thông tin '.$exits_user->fail_login.' lần, nếu quá 5 lần tài khoản sẽ bị khoá');
            }
            
            return redirect()->route("get.login")->with('login_fail','Sai tài khoản hoặc mật khẩu!');
        }

    }

    public function postRegister(RegisterRequest $request){
        $getMaster = "";
        if($request->aff){
            $getMaster = User::find($request->aff);
            if(!empty($getMaster)){
                if($getMaster->aff_flg != 1){
                    echo "Lỗi! link giới thiệu không tồn tại"; exit;
                }
            }else{
                echo "Lỗi! link giới thiệu không tồn tại"; exit;
            }
        }
        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->domain = $request->getHost();
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->master_user_id = $request->aff ?? NULL;
        $user->last_ip = $request->ip();
        $user->api_key = md5($user->username.uniqid().time());
        $user->save();
        return redirect()->route('get.login')->with('register_completed' , 'Tạo tài khoản thành công. Bạn có thể đăng nhập');
    }

    public function listUser(){
        $users = User::all();
        return view('dashboard.list_user', compact('users'));
    }

    public function account(){
        $user = Auth::user();
        $user_aff = User::where('master_user_id', $user->id)->get();
        return view('dashboard.account', compact('user','user_aff'));
    }

    public function doimatkhau(ChangePassRequest $request){
        $user = Auth::user();
        $getUser = User::find($user->id);
        $getUser->password = bcrypt($request->password);
        $getUser->save();
        return redirect()->route('account')->with('success','Đổi mật khẩu thành công!');
    }

    public function edit($id){
        $user = User::find($id);
        return view('dashboard.edit_user', compact('user'));
    }

    public function post_edit(EditUserRequest $request,$id){
        $user = User::find($id);
        $user->email = $request->email;
        $user->role = $request->role;
        $user->chietkhau = $request->chietkhau;
        $user->aff_flg = $request->aff_flg ?? 0;
        if(!empty($request->password)){
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return redirect()->back()->with('success','Edit thành công!');
    }

    public function bulk_update_user(Request $request){
        $user = User::find($request->user_id);
        $user->is_band = $request->checked === "true" ? 0 : 1;
        $user->save();
        return response()->json([
            'status' => true
        ]);
    }
}