<?php

namespace Coder\LaravelDash\Traits;

use Illuminate\Http\Request;

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
}