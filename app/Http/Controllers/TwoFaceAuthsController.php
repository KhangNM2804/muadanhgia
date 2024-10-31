<?php

namespace App\Http\Controllers;

use App\Http\Requests\Code2FACodeRequest;
use Illuminate\Http\Request;

class TwoFaceAuthsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $user = auth()->user();
        $googleAuthenticator = new \PHPGangsta_GoogleAuthenticator();
        // Tạo secret code
        $secretCode = $googleAuthenticator->createSecret();
        // Tạo QR code từ secret code. Tham số đầu tiên là tên. Chúng ta sẽ hiển thị
        // email hiện tại của người dùng. Tham số tiếp theo là secret code và tham số cuối cùng
        // là tiêu đề của ứng dụng. Sử dụng để người dùng biết code này đang sử dụng cho dịch vụ nào
        // Bạn có thể tùy ý sử dụng tham số 1 và 3.
        $qrCodeUrl = $googleAuthenticator->getQRCodeGoogleUrl(
            $user->username,
            $secretCode,
            config("app.name")
        );

        // Lưu secret code vào session để phục vụ cho việc kiểm tra bên dưới
        // và update vào database trong trường hợp người dùng nhập đúng mã được sinh ra bởi
        // ứng dụng Google Authenticator
        session(["secret_code" => $secretCode]);

        return view("two_face_auths.index", compact("qrCodeUrl","user"));
    }

    public function enable(Code2FACodeRequest $request)
    {
        $user = auth()->user();
        abort_if($user->secret_code, 404);
        // Khởi tạo Google Authenticator class
        $googleAuthenticator = new \PHPGangsta_GoogleAuthenticator();
        // Lấy secret code
        $secretCode = session("secret_code");

        // Mã người dùng nhập không khớp với mã được sinh ra bởi ứng dụng
        if (!$googleAuthenticator->verifyCode($secretCode, $request->get("code"), 0)) {
            return redirect()->route("2fa_setting")->with("error", "Code không đúng");
        }

        // Update secret code cho người dùng
        
        $user->secret_code = $secretCode;
        $user->save();

        return redirect()->route("account")->with("status_2fa", "2FA đã được kích hoạt!");
    }

    public function disable(Code2FACodeRequest $request)
    {

        $googleAuthenticator = new \PHPGangsta_GoogleAuthenticator();
        $secretCode = auth()->user()->secret_code;
        abort_if(!$secretCode, 404);

        if (!$googleAuthenticator->verifyCode($secretCode, $request->get("code"), 0)) {
            $errors = new \Illuminate\Support\MessageBag();
            $errors->add("code", "Authentication code không chính xác");
            return redirect()->back()->withErrors($errors);
        }

        $user = auth()->user();
        $user->secret_code = null;
        $user->save();
        return redirect()->route("account")->with("status_2fa", "2FA đã được tắt!");
    }
}
