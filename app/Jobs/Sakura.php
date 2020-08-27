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
    protected $timeout  = 20;    //设置超时时长
    protected $tries = 5;        //设置最大尝试次数
    /**
     * Create a new job instance.
     *
     * @return void
     */
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
    public function getConut(){
        $count=User::find(66)->select('age');
        Cache::put('count',$count,60*60*24);
        return $count;
    }
    public function handle()
    {
        //业务逻辑处理
        $count = Cache::get('count');
        if($count==0){
            return "库存不足！";
        }
        $count = $this->getConut();
        


        

    }
}
