<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    //
    protected $table = 'author';
    public $timestamps = false; 
    protected $fillable = ['id','name','user_id','address','test'];          //test是不存在的字段

    //为了队列测试，注释了
    // public function refToUser(){
    //     return $this->hasMany('App\\model\\User','id','user_id');
    // }
}
