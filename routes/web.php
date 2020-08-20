<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//测试路由
Route::get('/home', function () {
    return 'php的home地址';
});

//多个请求方式组合
Route::match(['get', 'post'], '/test', function () {
    //
    return 'match组合请求';
});

//any任意请求组合
Route::any('/test2', function () {
    //
    return 'any方式';
});

//路由可选参数(加上"?")和必选参数(不加问好)
Route::any('/test3/{id?}/{sakura}', function ($id = 0, $sakura) {
    return '页面的id为' . $id . "sakura的值为" . $sakura;
});

//分目录管理
Route::get('/home/controller', 'TestController@test1');

//Admin 分组
Route::group(['prefix' => 'Admin'], function ($route) {
    Route::get('/index', 'Admin\IndexController@index');
    Route::get('/test', 'Admin\IndexController@test');
    Route::get('/test1', 'Admin\IndexController@test1');
    Route::get('/test2', 'Admin\IndexController@test2');
    Route::get('/connect', 'Admin\IndexController@connect');
    Route::get('/getData', 'Admin\IndexController@getData');
    Route::get('/update', 'Admin\IndexController@update');
    Route::get('/select', 'Admin\IndexController@select');
    Route::get('/danGe', 'Admin\IndexController@danGe');
    Route::get('/danGe', 'Admin\IndexController@danGe');
    Route::get('/useModel', 'Admin\IndexController@useModel');
    Route::get('/show', 'Admin\IndexController@show');
    Route::get('/ModelGet', 'Admin\IndexController@ModelGet');
});
//TestController分组
Route::group(['prefix'=>'test'],function(){
    Route::get('/index', 'TestController@index');
    Route::get('/test', 'TestController@test');
    Route::get('/test1', 'TestController@change');
    Route::get('/test2', 'TestController@softDelete');
    Route::get('/test3', 'TestController@addUuid');
    Route::get('/test4', 'TestController@jiami');
    Route::get('/sakura', 'TestController@getSakura');
    Route::get('/son', 'Admin\SonController@DD');
    Route::get('/cache', 'Admin\SakuraController@cacheTest');
    Route::get('/getcache', 'Admin\SakuraController@getCache');
    Route::get('/test66', 'TestController@getCache');
    Route::get('/ceshisakura', 'Admin\SakuraController@ceshi');
    Route::get('/qingkongsakura', 'Admin\SakuraController@qingkong');
    Route::get('/redis', 'Admin\SakuraController@testRedis');
    Route::get('/info', 'Admin\SakuraController@info');
    
    Route::get('/ceshi', 'TestController@ceshi');
    Route::get('/qingkong', 'TestController@qingkong');
   
});

//通过中间件访问showage,sakura构造器还在中间件之前执行，已经打印出来了
Route::get('/showage',"Admin\SakuraController@get")->middleware(\App\Http\Middleware\ShowAge::class);

