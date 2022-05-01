<?php

namespace App\Exceptions;

use Throwable;
use App\Exceptions\ThrottleException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function ($request, RequestException $exception) {
            if ($exception instanceof ValidationException) {
                if ($request->expectsJson()) {
                    return response('Sorry, validation failed.', 422);
                }
            }

            if ($exception instanceof ThrottleException) {
                if ($request->expectsJson()) {
                    return response('You are replying too frequently. Please, take a break.', 429);
                }
            }

            return parent::render($request, $exception);
        });
    }
}
