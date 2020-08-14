<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;           //引入软删除

class Test extends Model
{
    //
    use SoftDeletes;                      //开启软删除
    protected $table = 'test' ;
    public $timestamps = false;         //时间戳 
    protected $fillable = ['id','username'];
    protected $dates = ['delete_at'];

}
