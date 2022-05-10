<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;

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
        });

        //validation exception
        $this->renderable(function (ValidationException  $e, $request) {
            // return response()->view('errors.invalid-order', [], 500);
            // dd($e);
            $response = [
                "data" => [
                    'message' => $e->getMessage(),
                    'errors' => $e->errors(),
                    'user' => '',
                    'token' => '',

                ]

            ];

            return response()->json($response, 500);
        });

        //Not found exception
        $this->renderable(function (NotFoundHttpException $e, $request) {
            $response = [
                "data" => [
                    'message' => 'Page Not Found',
                    'errors' => '',
                    'user' => '',
                    'token' => '',

                ]

            ];
            return response()->json($response, 404);
        });

        //AuthenticatinException
        $this->renderable(function (AuthenticationException $e, $request) {
            $response = [
                "data" => [
                    'message' => $e->getMessage(),
                    'errors' => '',
                    'user' => '',
                    'token' => '',
                ]
            ];
            return response()->json($response, 500);
        });
    }
}
