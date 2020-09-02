<?php

namespace App\Exports;

use App\model\Author as Author;
use Illuminate\Support\Facades\Auth;
//需要更改为FromArray
use Maatwebsite\Excel\Concerns\FromArray;

class TestExport implements FromArray
{
    //项目中根据此id找出数据库对应的数据信息
    private $id;
    public function __construct($id)
    {
        $this->id = $id;
    }

    //成功1 ，但是导出的数据格式有点奇怪
    // public function array(): array
    // {
    //     //导出的格式很奇怪
    //     $data = Author::all()->map(function ($value) {
    //         return (array) $value;
    //     })->toArray(); 

    //     //echo $data;
    //     //$data = $data;
    //     // $data = [[$this->id, $this->id, $this->id], [1, 2, 3], [4, 5, 6], [7, 8, 9]]; //测试数据
    //     // return $data;
    //     return $data;
    // }

    //调整之后的数据格式，正常，跟navicat导出的excel的一致
    public function array(): array
    {
        ini_set('memory_limit', '500M');
        set_time_limit(0); //设置超时限制为0分钟
        $cellData = Author::select('id', 'name', 'user_id', 'address')->limit(5)->get()->toArray();
        // var_dump($cellData);
        // echo '<br />';
        //echo "第一步的celldata为".$cellData."<br />";
        // $cellData[0] = array('ID','姓名','用户id','地址');
        // var_dump($cellData);
        // echo '<br />';
        for ($i = 0; $i < count($cellData); $i++) {
            $cellData[$i] = array_values($cellData[$i]);
            $cellData[$i][0] = str_replace('=', ' ' . '=', $cellData[$i][0]);
        }
        return $cellData;
    }
}
