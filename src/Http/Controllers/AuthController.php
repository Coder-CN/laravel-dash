<?php

namespace Coder\LaravelDash\Http\Controllers;

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
    
    /**
     * 获取用户基本信息
     */
    public function getUserInfo()
    {
        $admin = Auth::guard('admin')->user();
        return $this->success([
            'avatar' => $admin->avatar,
            'id' => $admin->id,
            'lastLoginIp' => $admin->last_login_ip,
            'lastLoginTime' => $admin->last_login_at->timestamp * 1000,
            'name' => $admin->nickname,
            'role' => [
                'permissionList' => [],
                'permissions' => [
                    [
                        'roleId' => 'admin',
                        'permissionId' => 'result',
                        'permissionName' => '结果权限',
                        'actions' =>  
                            '[{"action":"add","defaultCheck":false,"describe":"新增"},{"action":"query","defaultCheck":false,"describe":"查询"},{"action":"get","defaultCheck":false,"describe":"详情"},{"action":"update","defaultCheck":false,"describe":"修改"},{"action":"delete","defaultCheck":false,"describe":"删除"}]',
                        'actionEntitySet' => [
                          [
                            'action' => 'add',
                            'describe' => '新增',
                            'defaultCheck' => false
                          ],
                          [
                            'action' => 'query',
                            'describe' => '查询',
                            'defaultCheck' => false
                          ],
                          [
                            'action' => 'get',
                            'describe' => '详情',
                            'defaultCheck' => false
                          ],
                          [
                            'action' => 'update',
                            'describe' => '修改',
                            'defaultCheck' => false
                          ],
                          [
                            'action' => 'delete',
                            'describe' => '删除',
                            'defaultCheck' => false
                          ]
                        ],
                        'actionList' => null,
                        'dataAccess' => null
                    ],
                ]
            ]
        ]);
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
}
