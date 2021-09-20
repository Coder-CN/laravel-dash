<?php

namespace Coder\LaravelDash\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OperationLog
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Pre-Middleware Action
        Auth::guard('admin')->user()->recordOperation();
        $response = $next($request);

        // Post-Middleware Action

        return $response;
    }
}
