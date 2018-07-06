<?php

namespace App\Http\Requests\Api;

class LoginRequest extends Request
{
    public function rules()
    {
        return [
             'email' => 'required',
             'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => '邮箱不能为空',
            'password.required' => '密码不能为空',
        ];
    }
}
