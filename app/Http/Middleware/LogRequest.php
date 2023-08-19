<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\LogRequest as LogRecord;
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
            $log = [];
            $log['url']    = $request->fullUrl();
            $log['method'] = $request->method();
            $log['request_data'] = json_encode( $request->all());
            $data = $response->original;
            $statusCode = $response->status();
            $responseData = [
                'status' => $statusCode >= 200 && $statusCode < 300 ? 'success' : 'error',
                'data' => $data,
            ];
            $log['response_data'] = json_encode($responseData);
            $log['created_at'] = date("Y-m-d H:i:s");

            $LogRecord = new LogRecord;
            $LogRecord->setTable()->create($log);
            return $response;
    }
}