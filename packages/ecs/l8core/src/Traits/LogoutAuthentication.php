<?php

namespace Ecs\L8Core\Traits;

use App\Http\Responses\SuccessResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait LogoutAuthentication
{
    /**
     * Logout
     *
     * @param Request $request
     * @return SuccessResponse
     */
    public function logout(Request $request)
    {
        Auth::user()->token()->revoke();

        return new SuccessResponse('logout.succeed');
    }
}
