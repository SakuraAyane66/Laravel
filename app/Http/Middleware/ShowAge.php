<?php

namespace App\Http\Middleware;

use Closure;

class ShowAge
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
        echo $request;
        return $next($request); //控制器

        // if(request('name')!=='admin'){
        //     return redirect()->to('/');
        // }

        // //后置中间件
        // $response = $next($request);
        // echo "后置中间件，age等于20";
        // return $response;
    }
}
