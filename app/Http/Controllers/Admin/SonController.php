<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\SakuraController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SonController extends SakuraController          //子类继承父类
{
    //
    public function DD(Request $request){
        echo "直接调用父类的方法".$this->get();
    }
}
