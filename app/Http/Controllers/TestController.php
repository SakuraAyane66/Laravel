<?php

namespace App\Http\Controllers;

use App\model\Test as Test;
use Illuminate\Http\Request;                //命名空间三元素：常量，方法，类
use Illuminate\Support\Str;                 //引入str
use App\Http\Controllers\Admin\SakuraController as Sakura;
use Cache;


//没有引入Controller的原因是在同级目录，能够使用基类controller
class TestController extends Controller
{
    //
    public function test1()
    {
        return phpinfo();
    }
    public function index(Request $request)
    {
        // $data = $request->all();
        // $data1 = $request->get('id','1中文');
        // $arr = ['id'=>'66','username'=>'sakura'];
        // $test = new Test();
        // $test ->create($arr);         //调用create必须在fillable里面添加字段,并且插入的内容必须是数组格式
        // echo $test;
        $test = new Test();
        // $arr = ['id'=>'666','username'=>'ayane'];
        // $test ->insert($arr);         //插入
        $data = Test::find(2);           //根据静态方法查询，find内为主键id,结果集默认为一个对象，如果要将对象的结果集转化为数组，最终添加一个方法的调用
        echo "现在还是对象" . $data . "<br />";
        // $arrdata = $data->toArray();                      //会报错，无效
        // echo "转换之后的形式".$arrdata."<br />";
        $name = $data->username;        //在查询结果中寻找username
        echo "name为" . $name . "<br />";
        dd($data);
    }
    public function test(Request $request)
    {
        $test = new Test();
        $result = Test::where('id', '>', '3')->first();          //找出第一条符合的记录
        $result2 = Test::where('id', '>', '0')->limit(3)->get();     //找出id>3的记录，并且limit限制为3，并且get取出数据。
        //$result3 = Test::all();                             //all是找出所有的记录，all方法中间不能连接其他的任何方法
        $result3 = Test::all(['id']);                         //all是查询多个指定字段的值
        echo "result的结果是" . $result . '<br />';
        echo "result2的结果是" . $result2 . "<br />";
        echo "result3的结果是" . $result3 . "<br />";
    }
    public function change()
    {
        // $data = Test::find('666');
        // echo "find找出的data数据为".$data.'<br />';
        // $data ->username = 'CTL';    
        $test = new Test();
        //$test->where('id',null)->delete();         //删除了id为Null的记录
        //$test->delete();
        echo "test的值为" . $test;
    }
    public function softDelete()
    {
        // $test = Test::find(666);
        // $test->delete();
        // if ($test->trashed()) {
        //     echo '软删除成功！';
        //     dd($test);
        // } else {
        //     echo '软删除失败！';
        // }
        $m = Test::withTrashed()->get();
        dd($m);
        return;
    }
    public function addUuid()
    {
        $data = Str::uuid();
        echo "UUid是" . $data;
    }
    public function jiami()
    {
        $test = '123456';
        $test1 = 'sakura';
        $test2  = 'ayane';
        $data = encrypt("$test-$test1-$test2");
        echo "加密后的data为".$data."<br />";
        $result = decrypt($data);
        echo "解密之后的data为".$result;
    }
    // public function crypt()
    // {
    //     $pswd = '123456';
    //     $pswd_lock = Crypt::encrypt($pswd); //加密$pswd
    //     echo $pswd_lock . '<br/>';
    //     $pswd_open = Crypt::decrypt($pswd_lock);
    //     echo $pswd_open;
    // }
    public function getSakura(){
        $result = Sakura::getName();      //调用Sakura的静态方法
        $smallsakura= new Sakura("CTL");
        $smallsakura->get();
        Sakura::getName();        
    }
    public function getCache(){
  /*       $result1 = Cache::get("username");
        echo "是否能在第二个函数中调用".$result1; */
        echo Cache::get("CTL111");
    }
    public function ceshi(){
        Cache::put("CTL111","马上下班",60*60);   //设置为1小时
    }
    public function qingkong(){
        Cache::flush();           //清空缓存
    }
}
