<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Route;
use App\Jobs\Sakura;   //引入队列
use App\model\Author;  //引入队列使用的相关模型
// use Illuminate\Filesystem\Cache;
use Cache;
// use Redis;
use Illuminate\Support\Facades\Redis as Redis;

class SakuraController extends Controller
{
    //
    protected $ayane = '';            //定义私有变量ayane
    static $cc = '';
    public function __construct($ayane = 'ayane')
    {
        echo "这是Sakura类的构造方法 <br />";
        $this->ayane = $ayane;
        self::$cc = $ayane;
    }
    static public function getName()
    {                               //静态方法只能调用静态属性
        echo '访问ayane好麻烦=' . self::$cc;
        return self::$cc;
    }
    public function get()
    {
        echo '实例化后的方法' . $this->ayane . "<br />";
    }
    public function cacheTest()
    {
        //项目用的是remeber,获取并设置默认值
        //Cache::remember('user',$time,function(){});
        // $value = Cache::remember(‘users‘, $minutes, function() {
        //          return DB::table(‘users‘)->get();
        //      });
        //设置一个缓存，put如果重名，则覆盖  ,add 重名不更新，不重名更新。
        Cache::put("PHP  Intelephense", '垃圾', 999);         //垃圾活垃圾活，插件报错这不是坑人么
        Cache::put('sakura', 'siki', 9999);
        Cache::forever('username', 'Sakura siki');           //foreve永久存储，但并不是永久
        $result = Cache::put('sakura', '超siki', 10);         //Cache将缓存已经改为了⭐⭐⭐⭐⭐秒,第三个参数⭐⭐⭐⭐⭐
        //$result = Cache::put('sakura', 'siki', 10);
        //dd($result);
        /* 
        删除缓存
        Cache::pull("key"); 获取之后再删除，一般设置一次性存储的数据
        Cache::forge('key');  //删除一项
        Cache::flush();       //清除所有缓存，并且删除对应的目录
        */
    }
    //获取caceh
    public function getCache()
    {
        /*        //获取cache里面的值
        echo "修改了源文件之后不能读取file里面的cache？".$value = Cache::get("sakura")."<br />";
        //获取cache里面的值,get(),第一个为获取指定的key值，如果不存在则使用默认值（第二个参数）
        $value  = Cache::get("sakura", "default");
        //也支持从数据库中读取值返回(第二个参数)
        // $value = Cache::get('sakura',function(){
        //     return Db::table()->get();
        // });
        echo "cache中的值".$value."<br />";
        if(Cache::has('sakura')){          //has判断是否存在缓存
            $a = 'true';   
        }else {
            $a = 'false';
        }
        echo 'key是否存在'.$a."<br />"; */

        echo "在这里获取清空之后的" . Cache::get("CTL");
    }
    public function ceshi()
    {
        Cache::put("CTL", "马上下班", 60 * 60);   //设置为1小时
    }
    public function qingkong()
    {
        Cache::flush();           //清空缓存
    }
    public function testRedis()
    {
        // Redis::set("siki", "sakura ayane");
        $res = Redis::get("siki");
        echo "缓存的内容是" . $res . "<br />";
        // redis的哈希类型
        // Redis::hmset('happy:huizhou', ['name' => "惠州"]);
        // Redis::hmset("fail:xiaoshou", [
        //     "lover" => "黑嘿嘿?",
        //     'nice' => "我是xiaoshou",
        //     '挑衅' => '来打我啊'
        // ]);
        dump(Redis::hgetall("happy:huizhou"));
        dump(Redis::hgetall('fail:xiaoshou'));
        //echo "缓存的内容是" . $res1 . "<br />";
        echo "<br/><hr/>";
       
    }
    public function info()
    {
        phpinfo();
    }
    public function getRedis()
    {
        $res = Redis::get("siki");
        echo "缓存的内容是" . $res;
    }

    //Sakura队列的测试方法，尝试获取goods
    public function tryGetGoods(Request $request){
      $id = rand(1,3); //随机函数1~3 ，模拟3个用户发起请求
      $author = Author::find($id);
      $job = new Sakura($author);
      if($id==1){
        $level = 'high';
      }else {
        $level = 'Sakura';
      }
      //发送到队列，根据id看进入那个队列
      $job ->dispatch($job)->onConnection('redis')->onQueue($level)->delay(3);

      return "您已经进入了排队状态，请等待结果！";
    }   

}
