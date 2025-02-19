<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

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
        // 419エラー (CSRFトークン不一致) のログ出力
        $this->reportable(function (TokenMismatchException $e) {
            Log::warning('CSRF Token mismatch detected!', [
                'url' => request()->fullUrl(),
                'ip' => request()->ip(),
                'user-agent' => request()->header('User-Agent'),
                'session' => session()->all(),
                'exception' => $e->getMessage(),
            ]);
        });

        // 他のすべてのエラーをログに記録
        $this->reportable(function (Throwable $e) {
            Log::error($e->getMessage(), [
                'exception' => $e,
                'url' => request()->fullUrl(),
                'ip' => request()->ip(),
                'user-agent' => request()->header('User-Agent'),
            ]);
        });
    }
    // public function register()
    // {
    //     $this->reportable(function (Throwable $e) {
    //         Log::error($e->getMessage(), ['exception' => $e]);
    //     });
    // }
    // public function report(Throwable $exception)
    // {
    //     Log::error($exception->getMessage(), ['exception' => $exception]);
    //     parent::report($exception);
    // }
}
