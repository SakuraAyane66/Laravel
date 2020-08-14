<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SakuraController extends Controller
{
    //
    protected $ayane = '';            //定义私有变量ayane
    static $cc ='';
    public function __construct($ayane = 'ayane')
    {
        echo "这是Sakura类的构造方法 <br />";
        $this->ayane = $ayane;
        self::$cc = $ayane;
    }
    static public function getName(){                               //静态方法只能调用静态属性
        echo '访问ayane好麻烦='.self::$cc;                            
        return self::$cc;
    }
    public function get(){
        echo '实例化后的方法'.$this->ayane."<br />";
    }
}
