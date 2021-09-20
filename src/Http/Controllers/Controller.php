<?php

namespace Coder\LaravelDash\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($data = [], $msg = null)
    {
        $response = [
            'status' => 200,
            'result' => $data,
            'message' => $msg ?: 'Success',
            'timestamp' => time(),
        ];

        return response()->json($response, 200);
    }

    public function fail($msg = null, $data = [], $status = 500)
    {
        $response = [
            'status' => $status,
            'result' => $data,
            'message' => $msg ?: 'Fail',
            'timestamp' => time(),
        ];

        return response()->json($response, $status);
    }
}
