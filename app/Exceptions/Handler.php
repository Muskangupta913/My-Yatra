<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Handle "API endpoint not found" (404 error)
        if ($exception instanceof NotFoundHttpException && $request->is('api/*')) {
            return response()->json([
                'status' => 'error',
                'message' => 'The API endpoint you are trying to access does not exist.'
            ], 404);
        }

        // Handle Validation errors
        if ($exception instanceof ValidationException) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'errors' => $exception->errors()
            ], 422);
        }

        // Handle unauthorized access
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to access this API.'
            ], 401);
        }

        // Handle all other exceptions (for API only)
        if ($request->is('api/*')) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }

        // Fallback to the default handler for non-API routes
        return parent::render($request, $exception);
    }
}
