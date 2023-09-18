<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
    {
        switch ($e) {
            case $e instanceof \Illuminate\Auth\Access\AuthorizationException:
                $code = 403;
                break;
            case $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException:
                $code = 404;
                break;
            case $e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException:
                $code = 405;
                break;
            case $e instanceof \Illuminate\Database\QueryException:
                $code = 500;
                break;
            case $e instanceof UnauthorizedHttpException:
            case $e instanceof \Illuminate\Auth\AuthenticationException:
                $code = 401;
                break;
            default:
                return parent::render($request, $e);
        }

        return response()->json([
            'code' => $code,
            'message' => $e->getMessage()
        ], $code);

    }
}
