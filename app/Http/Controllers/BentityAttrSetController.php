<?php
namespace App\Http\Controllers;
use App\Models\BentityAttrSet;
//use App\Http\Requests\Request;
use App\Http\Controllers\Controller;
use App\Models\Bentity;
use App\Models\Tasktype;
use App\Repositories\BenattrsetRepository;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Flash;


class BentityAttrSetController extends Controller{

    //定义构造
    /** @var  TasktypeRepository */
    private $BenAttrsetRepository ;
//    private $tasktypeRepository;
//    private $taskTypeEavRepo;
//    public function __construct(TaskRepository $taskRepo,TasktypeRepository $tasktypeRepo,Tasktype_eavRepository $tasktype_eavRepository)
    public function __construct(BenAttrsetRepository $benattrRepository)
    {
        $this->BenAttrsetRepository = $benattrRepository;
//        $this->tasktypeRepository = $tasktypeRepo;
//        $this->taskTypeEavRepo = $tasktype_eavRepository;
    }



   public function index(){
      $BentityAttrSet= BentityAttrSet::all();
       $getBentityList=$this->BenAttrsetRepository->getBentityList();
       $getTasktypeList=$this->BenAttrsetRepository->getTasktypeList();
       return view('bentityattr.index',compact('BentityAttrSet','getBentityList','getTasktypeList'));
   }
    //新增显示
    public function create(){

        $getBentityList=$this->BenAttrsetRepository->getBentityList();
        $getTasktypeList=$this->BenAttrsetRepository->getTasktypeList();

        return view('bentityattr.create' ,compact("getBentityList","getTasktypeList"));
    }
//保存
  public function store(Request $request){
      $data = $request->all();
//      dd($data);

      $bentity_id=$request->input('bentity_id');
      $tasktypes_id=$request->input('tasktypes_id');
      if(BentityAttrSet::where(["bentity_id"=>$bentity_id,"tasktypes_id"=>$tasktypes_id])->count()>=1){
          Flash::success("该业务库类型配置已存在，请重新配置！");
          return redirect(route('benattrset.index'));
      }else{
          BentityAttrSet::create($data);
          Flash::success("保存成功！");
          return redirect(route('benattrset.index'));
      }

  }
    //编辑
    public function edit($id){
        $bentitype=$this->BenAttrsetRepository->find($id);
        $getBentityList=$this->BenAttrsetRepository->getBentityList();
        $getTasktypeList=$this->BenAttrsetRepository->getTasktypeList();
//        dd($bentitype->bentity->name);
        return view("bentityattr.edit",compact('bentitype','getBentityList','getTasktypeList'));
    }
    //修改
    public function update(Request $request, $id){
        $data=$request->all();
//        dd($data);
        $bentity_id=$request->input('bentity_id');
        $tasktypes_id=$request->input('tasktypes_id');
        if(BentityAttrSet::where(["bentity_id"=>$bentity_id,"tasktypes_id"=>$tasktypes_id])->count()>=1){
            Flash::success("该业务库类型配置已存在，请重新配置！");
            return redirect(route('benattrset.index'));
        }else{
            $bentitype=$this->BenAttrsetRepository->find($id);
            $bentitype->update($data);
            Flash::success("修改成功！");
            return redirect(route('benattrset.index'));
        }
    }
    //删除
    public function destroy($id){
        $benattrset=$this->BenAttrsetRepository->find($id);
        $benattrset->delete();
        Flash::success("删除成功！");
        return redirect(route('benattrset.index'));
    }
}









