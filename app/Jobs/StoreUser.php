<?php

namespace App\Jobs;

use App\model\User as User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //依赖注入user
        $this->user = $user->withoutRelations();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $this->user->id = 666;
        $this->user->age = "26";
        $this->user->name = "Sakur Ayane";
        $this->user->address = "Japan Tokyo";
        $this->user->username = "sakura";
        $this->user->password = "Onishi Saori";
        $this->user->save(); //保存
    }
    public function fail()
    {
        dd('发送失败');
    }
}
