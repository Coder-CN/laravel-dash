<?php

namespace Coder\LaravelDash\Http\Controllers;

use Coder\LaravelDash\Http\Resources\Admin as ResourcesAdmin;
use Coder\LaravelDash\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * 登录
     */
    public function signin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => '请输入用户名',
            'password.required' => '请输入登录密码'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $admin = Admin::where('username', $username)->first();
        if (!$admin || !Hash::check($password, $admin->password)) {
            return $this->fail('用户名与密码不匹配');
        }
        if ($admin->is_ban) {
            return $this->fail('已被禁止登陆');
        }
        
        $admin->login($request);

        return $this->success([
            'id' => intval($admin->id),
            'avatar' => $admin->avatar,
            'name' => $admin->nickname,
            'token' => $admin->api_token,
            'lastLoginIp' => $admin->last_login_ip,
            'lastLoginTime' => $admin->last_login_at->timestamp * 1000,
        ]);
    }
}
