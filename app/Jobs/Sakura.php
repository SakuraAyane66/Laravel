<?php

namespace App\Jobs;

use App\model\Author as Author;
use App\model\User as User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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
    //获取$count的值
    public function getConut(){
        $user=User::where('name','CTL')->first();
        $count = $user->age;
        Cache::put('count',$count,60*60*24);
        return $count;
    }
    //$count -1 
    public function desCount(){
        // $count=User::where('name','CTL')->select('age');
        // if($count>0){
        //     $count--;
        //     $res = User::where('name','CTL')->update(['age'=>$count]);
        //     return $res;  //返回修改的行数
        // }
        // return $count;        //$count <= 0的时候，直接返回

        $user=User::where('name','CTL')->first();
        $count = $user->age;
        $count--;
        $res = User::where('name','CTL')->update(['age'=>$count]);
        return $res;  //返回修改的行数
    }
    public function handle()
    {
        //业务逻辑处理
        // dd(User::where('name','CTL')->select('age'));
        echo "这里没问题吧？\r\n";
       
        //  $num =  User::where('name','CTL')->first();
        //  $cc = $num->age;
        // echo "num等于".$cc;
        $count = Cache::remember('count',60*60*24,function(){
            return User::where('name','CTL')->first()->age;
        });
        echo "到这里呢？";
        // dd($count);
        if($count==0){
            return "库存不足！";
        }
        // 应该在整合一下，把逻辑中的查询和减少放在一起
        $count = $this->getConut();
        if($count>0){
            $this->desCount();          //修改数据库中记录，$count -1
        }
        return "恭喜您!".$this->author->name."您已经购买成功！";
    }
}
