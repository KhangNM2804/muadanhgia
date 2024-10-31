<?php

namespace App\Http\Controllers;

use App\Http\Requests\Code2FACodeRequest;
use Illuminate\Http\Request;

class VerifyTwoFaceController extends Controller
{
    public function index()
    {
        return view("verify_two_face.index");
    }

    public function verify(Code2FACodeRequest $request)
    {

        $googleAuthenticator = new \PHPGangsta_GoogleAuthenticator();
        $secretCode = auth()->user()->secret_code;

        if (!$googleAuthenticator->verifyCode($secretCode, $request->get("code"), 0)) {
            $errors = new \Illuminate\Support\MessageBag();
            $errors->add("code", "Invalid authentication code");
            return redirect()->back()->withErrors($errors);
        }

        session(["2fa_verified" => true]);
        return redirect()->route("dashboard");
    }
}