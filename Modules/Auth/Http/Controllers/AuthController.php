<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\Controller;
use Modules\Users\Models\User;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $email = "ahmed2k@gmail.com";

        $user = User::whereEmail($email)->first();

        $token = $user->createToken("login-user")->accessToken;

        return $this->success(['token' => $token]);

    }
}
