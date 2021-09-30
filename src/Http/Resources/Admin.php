<?php

namespace Coder\LaravelDash\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Admin extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'avatar' => $this->avatar,
            'id' => $this->id,
            'lastLoginIp' => $this->last_login_ip,
            'lastLoginTime' => $this->last_login_at->timestamp * 1000,
            'name' => $this->nickname,
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
        ];
    }
}
