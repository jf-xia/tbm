<?php
namespace App\Http\Controllers;
use App\Models\BentityUser;
use App\Http\Controllers\Controller;
use App\Repositories\BentityuserRepository;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Flash;
use Qiniu\Auth;

class BentityUserController extends Controller{

    //定义构造

    private $BentityuserRepository;

    public function __construct(BentityuserRepository $bentityuserRepository)
    {
        $this->BentityuserRepository = $bentityuserRepository;
//        $this->tasktypeRepository = $tasktypeRepo;
//        $this->taskTypeEavRepo = $tasktype_eavRepository;
    }



    public function index(){
        $BentityUser= BentityUser::all();
        return view('bentityuser.index',compact('BentityUser'));
    }
    //新增显示
    public function create(){

        $user=\Auth::user();
         $getUserList=$this->BentityuserRepository->getUserList();
         $getTasktypeList=$this->BentityuserRepository->getTasktypeList();
       return view('bentityuser.create' ,compact("getTasktypeList","getUserList"));
    }
//保存
    public function store(Request $request){
        $data = $request->all();
//        dd($data);
        $user_id=$request->input('user_id');
        $tasktypes_id=$request->input('tasktypes_id');

        if(BentityUser::where(["user_id"=>$user_id,"tasktypes_id"=>$tasktypes_id])->count()>=1){
            Flash::success("该业务库用户配置已存在，请重新配置！");
            return redirect(route('benuser.index'));
        }else{
//            BentityUser::create($data);
            $this->BentityuserRepository->create($data);
            Flash::success("保存成功！");
            return redirect(route('benuser.index'));
        }
   }

    //编辑
    public function edit($id){
        $bentityuser=$this->BentityuserRepository->find($id);
        $getUserList=$this->BentityuserRepository->getUserList();
        $getTasktypeList=$this->BentityuserRepository->getTasktypeList();
        return view("bentityuser.edit",compact('bentityuser','getUserList','getTasktypeList'));
    }
    //修改
    public function update(Request $request, $id){
        $data=$request->all();
//        dd($data);
        $user_id=$request->input('user_id');
        $tasktypes_id=$request->input('tasktypes_id');
        if(BentityUser::where(["user_id"=>$user_id,"tasktypes_id"=>$tasktypes_id])->count()>=1){
            Flash::success("该业务库用户配置已存在，请重新配置！");
            return redirect(route('benuser.index'));
        }else{
           $this->BentityuserRepository->find($id)->update($data);
            Flash::success("修改成功！");
            return redirect(route('benuser.index'));
        }

    }
    //删除
    public function destroy($id){
        $benuser=$this->BentityuserRepository->find($id);
        $benuser->delete();

        Flash::success("删除成功！");
        return redirect(route('benuser.index'));
    }
}








