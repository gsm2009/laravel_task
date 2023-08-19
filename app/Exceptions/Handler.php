<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Models\LogException;
use Illuminate\Support\Facades\Log;

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

    /**
     * 记录错误日志
     */
    public function report(Throwable $exception)
    {

        try {
            $logException = new LogException();
            $log_data = [
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'created_at' => date("Y-m-d H:i:s"),
            ];
            $logException->setTable()->create($log_data);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            Log::info(json_encode($log_data));
        }
        parent::report($exception);
    }

    /**
     * 自定义render ，统一异常json格式
     */
    public function render($request, Throwable $exception)
    {
        return app(\App\Exceptions\ApiExceptionHandler::class)->render($request, $exception);
    }
}