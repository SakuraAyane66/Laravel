<?php

namespace App\Exports;

use App\model\Author as Author;
use Illuminate\Support\Facades\Auth;
//需要更改为FromArray
use Maatwebsite\Excel\Concerns\FromArray;

class TestExport implements FromArray
{
    private $id;
    public function __construct($id)
    {
        $this->id = $id;
    }
    public function array(): array
    {
        //导出的格式很奇怪
        $data = Author::all()->map(function ($value) {
            return (array) $value;
        })->toArray(); 

        
        //echo $data;
        //$data = $data;
        // $data = [[$this->id, $this->id, $this->id], [1, 2, 3], [4, 5, 6], [7, 8, 9]]; //测试数据
        // return $data;
        return $data;
    }
}
