<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // 将响应转换为 JSON 格式
        $data = $response->original;
        $statusCode = $response->status();
        $responseData = [
            'status' => $statusCode >= 200 && $statusCode < 300 ? 'success' : 'error',
            'data' => $data,
        ];

        // 设置响应的 Content-Type 为 application/json
        $response->header('Content-Type', 'application/json');
        $response->setContent(json_encode($responseData));

        return $response;
    }
}
