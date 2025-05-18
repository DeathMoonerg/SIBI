<?php

namespace App\Exceptions;

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
        
        // Handle database connection errors by continuing without database
        $this->renderable(function (\PDOException $e, $request) {
            if (str_contains($e->getMessage(), 'SQLSTATE[HY000]')) {
                return response()->view('errors.db-connection', [], 500);
            }
        });
    }
} 