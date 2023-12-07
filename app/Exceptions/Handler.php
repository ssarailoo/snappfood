<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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

    public function render($request, \Throwable $e)

    {
        if ($e instanceof AuthorizationException) {
            if ($request->wantsJson()) {
                return response()->json([
                    'data' => [
                        'error' => $e->getMessage()
                    ]
                ], $e->status() ?? 403);
            } else {
                return response()->view('error.403', ['exception' => $e], 403);
            }
        }
        if ($e instanceof ModelNotFoundException) {
            if ($request->wantsJson()) {
                return response()->json([
                    'data' => [
                        'error' => 'Resource not found'
                    ]
                ], 400);
            } else {
                return response()->view('error.404', ['exception' => $e, 'message' => 'Not Found'], 404);
            }
        }
        return parent::render($request, $e);
    }
}
