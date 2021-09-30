<?php

namespace Coder\LaravelDash\Http\Controllers;

use Coder\LaravelDash\Http\Resources\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * 获取用户基本信息
     */
    public function getUserInfo()
    {
        $admin = Auth::guard('admin')->user();
        return $this->success(new Admin($admin));
    }

    /**
     * 获取用户菜单栏
     */
    public function getUserNav()
    {
        return $this->success([Auth::guard('admin')->user()->getNav()]);
    }

    /**
     * 循环并获取子级菜单
     */
    public function getMenuChildren($menus, $permissions)
    {
        $children = [];
        // 循环二级权限
        foreach ($permissions as $permission) {
            // 循环二级菜单
            foreach ($menus as $menu) {
                if ($permission['name'] === $menu['name']) {
                    $children[] = $menu;
                    break;
                }
            }
        }

        return $children;
    }

    /**
     * 更新个人资料
     */
    public function update(Request $request)
    {   
        $admin = Auth::guard('admin')->user();
        if ($request->input('avatar')) {
            $admin->avatar = $request->input('avatar');
        } else if ($request->input('nickname')) {
            $admin->nickname = $request->input('nickname');
            if ($request->input('password')) {
                $admin->password = Hash::make($request->input('password'));
            }
        } else {
            return $this->fail();
        }
        $admin->save();

        return $this->success(new Admin($admin));
    }
}
