<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\LogRequest as LogRecord;
use Illuminate\Support\Facades\Log;

class LogRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {

        $response = $next($request);
        try {
            $log = [];
            $log['url'] = $request->fullUrl();
            $log['method'] = $request->method();
            $log['request_data'] = json_encode($request->all());
            $data = $response->original;
            $statusCode = $response->status();
            $data['statusCode'] = $statusCode;
            $responseData = [
                'status' => $statusCode >= 200 && $statusCode < 300 ? 'success' : 'error',
                'data' => $data,
            ];
            $log['response_data'] = json_encode($responseData);
            $log['created_at'] = date("Y-m-d H:i:s");

            $LogRecord = new LogRecord;
            $LogRecord->setTable()->create($log);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            Log::info(json_encode($log));
        }
        return $response;
    }
}