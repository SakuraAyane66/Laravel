<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class trade implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    public $timeout;         //超时时间
    public $tries;           //最大尝试次数
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //业务操作
        //1.检测是否支付 2.修改订单状态 3.增加积分 4.发放代金券等
        //操作数据库     -----完善业务逻辑
        $rand = mt_rand(1,2);
        if($rand ==2){
            sleep(3);
            throw new Exception('任务失败');
        }
        var_dump($rand,$this->data->data);

    }
    public function failed(Exception $exception){                           //失败处理
        var_dump($exception->getMessage());
    }
}
