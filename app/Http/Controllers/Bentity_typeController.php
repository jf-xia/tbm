<?php
namespace App\Http\Controllers;
use App\Models\Bentity_type;
use EasyWeChat\Core\Http;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Repositories\BentitypeRepository;
use Flash;
use App\Http\Requests;

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
        $name=$request->input("name");
        if(Bentity_type::where("name",$name)->count()>0){
            Flash::success("该业务库类型已存在，请重新输入！");
//            echo"<script> confirm('该业务库类型已存在，请重新输入！')</script>";
            return redirect(route('bentitype.index'));

        }else{
            Bentity_type::create($data);
            Flash::success("保存成功！");
            return redirect(route('bentitype.index'));
       }

    }

    //编辑页面
    public function edit($id){
        $bentitype=Bentity_type::find($id);
        return view("Bentitype.edit",compact('bentitype'));
    }
    //修改
    public function update(Request $request, $id){
        $data=$request->all();
       $name=$request->input('name');

        if(Bentity_type::where("name",$name)->count()>1){
            Flash::success("该业务库类型已存在，请重新输入！");
            return redirect(route('bentitype.index'));
        }else{
            $bentitype=Bentity_type::find($id);
            $bentitype->update($data);
            Flash::success("修改成功！");
            return redirect(route('bentitype.index'));
        }
    }
    //删除
    public function destroy($id){
     $bentitype=Bentity_type::find($id);
        $bentitype->delete();

        Flash::success("删除成功！");
        return redirect(route('bentitype.index'));

    }
}