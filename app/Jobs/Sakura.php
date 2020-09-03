<?php

namespace App\Jobs;

use App\model\Author as Author;
use App\model\User as User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

use Cache;

//控制器在SakuraController里面
class Sakura implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $author;
    protected $timeout  = 200;    //设置超时时长
    protected $tries = 5;        //设置最大尝试次数
    /**
     * Create a new job instance.
     *
     * @return void
     */
    // public function __construct(Author $author)
    // {
    //     //依赖注入,注入Author
    //     $this->author = $author;
    // }
    public function __construct(Author $author)
    {
        //依赖注入,注入Author
        $this->author = $author;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    //获取实际$count的值
    public function getConut()
    {
        $user = User::where('name', 'CTL')->first();
        $count = $user->age;
        // Cache::put('count', $count, 60 * 60 * 24);  //逻辑分到了desCount中
        return $count;
    }
    //$count -1 
    public function desCount()
    {
        $user = User::where('name', 'CTL')->first();
        $count = $user->age;
        $count--;
        //修改事务
        DB::beginTransaction();
        try {
            $res = User::where('name', 'CTL')->update(['age' => $count]);
            DB::commit();
        } catch (QueryException $exception) {
            DB::rollback();
            return "失败";
        }
        Cache::put('count', $count, 60 * 60 * 24);
        return $res;  //返回修改的行数
    }
    public function handle()
    {
        //业务逻辑处理
        echo "这里没问题吧？\r\n";
        //获取缓存
        $count = Cache::remember('count', 60 * 60 * 24, function () {
            return User::where('name', 'CTL')->first()->age;
        });
        echo 'count的数量为' . $count . "\r\n";
        if ($count == 0) {
            echo '库存不足';
            return "库存不足！";
        } else {
            // echo "成功到这里了！！\r\n";
            $this->desCount();          //修改数据库中记录，$count -1，并且修改cache
            return "恭喜您!" . $this->author->name . "您已经购买成功！";
        }
    }
}
