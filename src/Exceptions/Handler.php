<?php

namespace Coder\LaravelDash\Exceptions;

use Coder\LaravelDash\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        // 
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable               $exception
     *
     * @throws \Throwable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        $api = new Controller;

        if ($exception instanceof AuthenticationException) {
            return $api->fail($exception->getMessage(), [], 401);
        }

        if ($exception instanceof ModelNotFoundException) {
            return $api->fail('Data not found', [], 404);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $api->fail(null, [], 405);
        }

        if ($exception instanceof ValidationException) {
            return $api->fail($exception->validator->messages()->first(), [], 422);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $api->fail('404 Not Found', [], 404);
        }

        // return $api->fail($exception->getMessage(), [], $exception->getCode());

        return parent::render($request, $exception);
    }
}
