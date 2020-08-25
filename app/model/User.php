<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

/* 
     模型类
  1、（必做）定义一个$table属性，值为不要前缀的表明，不定义会默认为文件名的复数形式（users）         修饰词为protect
  2、（可选）定义一个$primary,值是主键名称，在主键字段不是id的时候需要指定主键，不使用默认主键为ID   修饰词为protect
  3、（可选）时间戳                                                                            修饰词为public
  4、（可选） 定义$fillable属性，表示使用模型中create方法插入数据时，要定义$fillable允许插入到数据库的字段信息（当然可以使用insert，就不需要设置$fillable）  修饰词：protect 

*/
class User extends Model
{
    //
    protected $table = 'user';    
    protected $primary = 'id';         // 主键为id     
    public $timestamps = false;         //时间戳 
    protected $fillable = ['id','age','username','password'];      //设置运行写入的字段，create

    public function getAuthor(){
      return $this->hasOne('App\\model\\Author','user_id','id');
    }
    public function getAuthorMany(){
      return $this->hasMany('App\\model\\Author','user_id','id');
    }
} 
