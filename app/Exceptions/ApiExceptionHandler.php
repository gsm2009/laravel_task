<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class ApiExceptionHandler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {

        // 将异常转换为 JSON 格式
        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : '';
        $statusCode = ($statusCode !== '') ? $statusCode : (isset($exception->statusCode) ? $exception->statusCode : 500);
        $responseData = [];

        $responseData = [
            'statusCode' => $statusCode,
            'message' => $exception->getMessage(),
        ];

        if ($_SERVER['APP_DEBUG'] == 'true') {
            $responseData['trace'] = $exception->getTrace();
        }

        if ($statusCode == 500 && $_SERVER['APP_DEBUG'] == 'false') {
            $responseData['message'] = 'Internal Server Error';
        }

        // 设置响应的 Content-Type 为 application/json
        return response()->json($responseData, $statusCode);
    }
}