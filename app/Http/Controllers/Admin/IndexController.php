<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Input;    //下面的Input是在app.php配置了的缩写名字，这是完整路径
//use Input;                                 //laravel 7 input已经弃用，用Request代替（见下test1方法）
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;                   //引入uuid

use App\model\User as User;                 //引入模型
use App\model\Test as Test;   
header('Content-Type: text/html; charset=gbk');                    //不行，不能转化为中文

/* 
           重点
   在查询中，后续的索引条件会受到前面查询记录的影响。
   比如前面查询 where('id',1)之后，后面的查询是从id=1的结果集中再次查询记录

   return response()->json($data)->setEncodingOptions(JSON_UNESCAPED_UNICODE);    //加上这一句转换就可以网页显示为中文
*/

class IndexController extends Controller
{
    //依赖注入
    protected $user;
    function __construct(User $user)
    {
        $this->user = $user;
    }
    public function show(){
        $data=$this->user->where('id','1')->get();
        return response()->json($data)->setEncodingOptions(JSON_UNESCAPED_UNICODE);    //加上这一句转换就可以了
        echo $data;
    }

    public function ModelGet(){
        $ret = Test::get();
        return $ret;
    }

    //
    public function index()
    {
        return "index目录";
    }
    //已经弃用
    // public function test(){
    //    // echo $request->Input('id','10086');
    //     echo Input::get('id','10086');
    // }

    //用Request代替了input
    public function test1(Request $request)
    {
        $id =  $request->input('id', '10011');         //第一个参数为接受名字，第二个为默认初始的值
        $age = $request->input('age', '22');
        echo 'id为' . $id;
        echo "<br />";
        echo 'age为' . $age;
        echo "<br />";
        // dd($age);
        echo 'request参数是什么' . $request;
    }
    public function test2(Request $request)
    {
        $all = $request->all();
        var_dump($all);
        dd($all);             //dd是dunp+die，会结束程序，后面的代码不执行
        echo '222';
    }
    public function connect()
    {
        $db = DB::table('test');
        $res1 = $db->insert([
            ['id' => 1, 'age' => 22, 'username' => 'usersakura', 'password' => 'ayane'],
            ['id' => 2, 'age' => 23, 'username' => 'bilibili', 'password' => '干杯！🍻'],
            ['id' => 3, 'age' => 24, 'username' => '狗', 'password' => '狗哥nb']
        ]);
        return $res1;
    }
    public function getData()
    {
        $db = DB::table('test');
        // $db1 = DB::table('test');
        // $test = $db ->where('id',3)->get();
        // echo "test的值为".$test;
        $rest = $db->get();              //查询全部数据，返回的是结果集
        // dd($rest);  
        //return json_encode($rest);
        $rest2 = $db->where('id', '<', 3)->get();                 //调用where 来条件查询
        $rest3 = $db->where('id', '<', 3)->where('age', 26)->get();    //where之后接续where 且操作  and查询。
        // $result = $db ->where('id','=',1)->get();
        // dd($result);
        echo 'where之后接续where，and操作的结果是' . $rest3 . '<br />';
        echo "id<3的情况" . $rest2 . '<br />';
        // foreach($rest as $key =>$value){         //$value是一个对象，要用对象的形式访问
        //     echo "id是".$value->id." age是".$value->age." username是".$value->username;
        //     echo "<br />";
        // }
        $rest4 = $db->where('id', 1)->orWhere('id', 3)->get();
        echo "orWhere或的查询结果是" . $rest4 . '<br />';           //orWhere是或操作，or查询
    }

    public function update()
    {
        $db = DB::table('test'); //定义需要操作的数据表
        $result = $db->where('id', '=', 1)->update([
            //update中是个数组
            'username' => 'sakura',
            'age' => 26
        ]);
        dd($result);
    }

    public function select()
    {
        $db = DB::table('test');
        $result = $db->where('id', '=', 1)->get();
        dd($result);
    }
    public function danGe(){
        $db = DB::table('test');
        $result = $db->where('id', '=', 1)->value('username'); //查询指定值
        $result1 = $db->orderBy('age','desc')->get();          //age降序排序
        $result2 = $db->limit(3)->offset(1)->get();            //查询结果从1之后开始，显示3条

        echo $result;
    }

    //使用模型
    public function useModel(){
        // $model = new User();            //实例化
        // var_dump($model);
        // printf($model);
        // $data = User::get();
        // //echo 'data长这样',$data;
        // return json_encode($data);
        // $model = new Test();
        // $model -> username = "CTL";
        // $model -> password= 'sakura';
        // $result = $model ->save();           //添加

        // echo "result".$result;

        $data = Test::get();
        //$data = Test::where('username','CTL')->delete();  //查询，并且删除
        return json_encode($data);
    }
}
