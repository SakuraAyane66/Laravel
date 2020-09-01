<?php

namespace App\Http\Controllers\Admin;
use App\Exports\TestExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
//目前是把kernel中的中间件给注释了
class FileController extends Controller
{
    //
    public function putFile(Request $request)
    {
        //尝试1
        // if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
        //     $photo = $request->file('photo');
        //     $extension = $photo->extension();          // 文件扩展名
        //     $store_request = $photo->storeAs('photo', 'test.jpg');   // 保存文件，返回文件路径/storage/app/photo/test.jgp
        //     $output = [
        //         'extension' => $extension,
        //         'store_result' => $store_request
        //     ];
        //     print_r($output);
        //     return "success";
        // }
        // return 'failed';

        //尝试2 ,大多数的尝试都成功了，只是路径没找到而已，该方法的路径在storage/app  下面 uploads目录 。
        $path = $request->file('photo')->store('uploads');
        return $path;

        //尝试3         可能目录是在public 目录下去了
        // $file = $request->file('photo');    //获取文件名称
        // //print_r($file);die;
        // if ($file->isValid()) {
        //     $clientName = $file->getClientOriginalName();    //客户端文件名称..
        //     echo "1 .".$clientName."<br />";
        //     $tmpName = $file->getFileName();   //缓存在tmp文件夹中的文件名例如php8933.tmp 这种类型的.
        //     echo "2 .".$tmpName."<br />";
        //     $realPath = $file->getRealPath();     //这个表示的是缓存在tmp文件夹下的文件的绝对路径
        //     echo "3 .".$realPath."<br />";
        //     $entension = $file->getClientOriginalExtension();   //上传文件的后缀.
        //     echo "4 .".$entension."<br />";
        //     $mimeTye = $file->getMimeType();    //也就是该资源的媒体类型
        //     echo "5 .".$mimeTye."<br />";
        //     $newName = $newName = md5(date('ymdhis') . $clientName) . "." . $entension;    //定义上传文件的新名称
        //     echo "6 .".$newName."<br />";
        //     $path = $file->move(public_path().'/storage/app/uploads', $newName);    //把缓存文件移动到制定文件夹
        //     echo "7 .".$path."<br />";
        //     //print_r($path);
        //     die;
        // }
    }

    //从服务器端获取文件，
    public function getFile(){
        $file_name = 'pt7C7sHMv5C09e0gWAxJyb97RfturpcaZk9mc9Rq.jpeg';
        return response()->file(storage_path().'\app\uploads\\'.$file_name);
    }
    public function getPost(Request $request)
    {
        $data = $request->input('name');
        echo "name is " . $data . "<br />";
        return $data;
    }
    public function getExcel($id=1){
        return Excel::download(new TestExport($id),'test.xlsx');
    }
    public function getExcel2(Excel $excel){
        $info = Author::all()->select('id','name','user_id','address')->get();
        foreach($info as $key=>$value){
            $export []=array(
             'ID'=>$value['id'],
             'name'=>$value['name'],
             'user_id'=>$value['user_id'],
             'address'=>$value['address']
            );
        }
        $table_name = 'Author';
        $excel->create($table_name, function($excel) use ($export) { 
            $excel->sheet('export', function($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');
    }
}
