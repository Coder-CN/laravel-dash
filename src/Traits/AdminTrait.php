<?php

namespace Coder\LaravelDash\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait AdminTrait
{
    /**
     * 操作日志记录
     */
    public function recordOperation($request = null)
    {
        $request = $request ?: request();
        $request->setTrustedProxies(['127.0.0.1', $request->server->get('REMOTE_ADDR')], Request::HEADER_X_FORWARDED_AWS_ELB);
        $this->operationLogs()->create([
            'path' => $request->path(),
            'method' => $request->method(),
            'ip' => $request->getClientIp(),
            'params' => $request->except(['password', 'pay_password']),
        ]);

        return true;
    }

    /**
     * 用户登录
     */
    public function login($request)
    {
        $this->api_token = Str::random(32);
        $this->last_login_at = now();
        $this->last_login_ip = $request->getClientIp();
        $this->save();
        return true;
    }

    /**
     * 获取权限菜单
     */
    public function getNav()
    {
        $permissions = $this->permissions;
        $all_menus = config('nav');
        $menus = $all_menus;
        $menus['children'] = [];
        if ($permissions['redirect']) {
            $menus['redirect'] = $permissions['redirect'];
        }

        // 循环一级权限
        foreach ($permissions['menus'] as $permission) {
            // 循环一级菜单
            foreach ($all_menus['children'] as $key => $menu) {
                if ($permission['name'] === $menu['name']) {
                    $menu['children'] = $this->getMenuChildren($menu['children'], $permission['children']);
                    $menus['children'][] = $menu;
                    unset($all_menus[$key]);
                    break;
                }
            }
        }

        return $menus;
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
}