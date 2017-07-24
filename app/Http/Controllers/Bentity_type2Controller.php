<?php
namespace App\Http\Controllers;
use App\Models\Bentity_type;
use EasyWeChat\Core\Http;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Repositories\BentitypeRepository;
use Flash;

class Bentity_typeController extends Controller{

    private $bentitype;

    public  function __construct(BentitypeRepository $bentype){
     $this->bentitype=$bentype;
    }

      public function index(){
          $data=Bentity_type::all();
         return view("Bentitype.index")->with('data1',$data);

      }



    //新增保存
    public function store(Request $request){
        $data = $request->all();
        $name=$request->input("bentype_name");
//        dd($data);
//        $bentitype=$this->bentitype->create($data);
//        dd($bentitype);
////        Flash::success('Project saved successfully.');
//        echo"保存成功";
        $ben=new Bentity_type();
        if(Bentity_type::where("name",$name)->count()>0){
//            return '<div class="alert alert-warning"><strong>“'.$name.'”</strong>已经存在！</div><div class="modal-footer">
//          <a href="'.url("bentitype") .'" class="btn btn-primary">确认</a>';
            return alert("保存成功！");
        }else{
            $ben->name=$name;
            $ben->context=$request->input("ben_desc");
            $ben->save();
            return '<div class="alert alert-info"><strong>'.$name.'</strong>增加成功！</div><div class="modal-footer">
                    <a href="'.url("bentitype") .'" class="btn btn-primary">确认</a>';
        }


    }

    //重复提示
//    public function exist(){
//         return view("bentitype.exist");
//    }
}