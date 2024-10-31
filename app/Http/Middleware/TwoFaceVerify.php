<?php

namespace App\Http\Middleware;

use Closure;

class TwoFaceVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Lấy secret_code hiện tại của user
        $secretCode = auth()->user()->secret_code;
        
        // Kiểm tra, nếu có secret_code và chưa có session 2fa_verified
        // Thực hiện redirect tới màn hình nhập Authentication code
        if ($secretCode && !session("2fa_verified")) {
            return redirect()->route("two_face.index");
        }
        return $next($request);
    }
}
