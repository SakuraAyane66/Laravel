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
});
//TestController分组
Route::group(['prefix'=>'test'],function(){
    Route::get('/index', 'TestController@index');
    Route::get('/test', 'TestController@test');
    Route::get('/test1', 'TestController@change');
    Route::get('/test2', 'TestController@softDelete');
    Route::get('/test3', 'TestController@addUuid');
    Route::get('/test4', 'TestController@jiami');
    
});
// Route::get('/Admin/index', 'Admin\IndexController@index');
// Route::get('/Admin/test', 'Admin\IndexController@test');
// Route::get('/Admin/test1', 'Admin\IndexController@test1');
// Route::get('/Admin/test2', 'Admin\IndexController@test2');
// Route::get('/Admin/connect', 'Admin\IndexController@connect');
// Route::get('/Admin/getData', 'Admin\IndexController@getData');
// Route::get('/Admin/update', 'Admin\IndexController@update');
// Route::get('/Admin/select', 'Admin\IndexController@select');
// Route::get('/Admin/danGe', 'Admin\IndexController@danGe');
// Route::get('/Admin/danGe', 'Admin\IndexController@danGe');
