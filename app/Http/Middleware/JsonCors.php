<?php

namespace App\Http\Middleware;

use \Illuminate\Http\JsonResponse;
use Closure;

class JsonCors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        echo "这是前置中间件"."<br />";
        $data = $next($request);
        if ($data instanceof \Illuminate\Http\JsonResponse) {
            $data->setEncodingOptions(JSON_UNESCAPED_UNICODE); 
            echo "data的数据是".$data."<br />";
            // 下面是跨域控制代码 $
            $data->withHeaders([
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Credentials' => 'true',
            ]);
        }
        return $data;
    }
}
