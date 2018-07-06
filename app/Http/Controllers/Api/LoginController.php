<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use Validator;
use App\Http\Controllers\Traits\ProxyHelpers;
use App\Http\Resources\User as UserResource;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\Api\LoginRequest;

class LoginController extends BaseController
{
    use ProxyHelpers;

    public function login(LoginRequest $request)
    {


        $user = User::where('email',$request->email)->first();

        if (!$user) {
            throw new UnauthorizedException('此用户不存在');
        }

        $tokens = $this->authenticate();

        return $this->succeed(['token' => $tokens, 'user' => new UserResource($user)]);
    }
}
