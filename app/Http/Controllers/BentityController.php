<?php
namespace App\Http\Controllers;
use App\Models\Bentity;
use App\Models\Tasktype;
use App\Models\Task;
//use Illuminate\Support\Facades\Request;
use App\Repositories\Criteria\Task\TasksByType;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\TaskRepository;
use App\Repositories\TaskgroupRepository;
use App\Repositories\Tasktype_eavRepository;
use App\Repositories\Tasktype_eav_valueRepository;
use App\Repositories\BentitsetRepository;
//使用其他的控制器，或继承时controller路径是否在同一命名空间下，若不在，就利用use引入进来。
use EasyWeChat\Core\Http;
//use Illuminate\Routing\Controller;
use Flash;


class BentityController extends Controller{

    private $taskRepository;
    private $taskgroupRepository;
    private $taskEavRepository;
    private $taskEavValueRepository;
    private $bentitsetRepository;
    public function __construct(TaskRepository $taskRepo,
                                TaskgroupRepository $taskgroupRepo,
                                Tasktype_eavRepository $taskEavRepo,
                                Tasktype_eav_valueRepository $taskEavValueRepo,
                                BentitsetRepository $bentitsetRepository )
    {
        $this->taskEavRepository = $taskEavRepo;
        $this->taskRepository = $taskRepo;
        $this->taskgroupRepository = $taskgroupRepo;
        $this->taskEavValueRepository = $taskEavValueRepo;
        $this->bentitsetRepository=$bentitsetRepository;

    }




    public function index(){
        return redirect(route('bentity.lists',['0','0']));

    }
    public function lists($id,$benId){

        //     dd($bename);
        //     $id参数为tasktype_id
        $bentity=Bentity::all();
        $tasktype=array_column(Tasktype::all()->sortBy('id')->toArray(),'name','id');
//        $bentityTypes = (array_column($bentity->toArray(),'tasktypes_id'));
        if (!$id){
           $id = $bentity->first()->tasktypes_id;
        }
        if(!$benId){
            $benId=$bentity->first()->id;
        }

        $taskRepo = $this->taskRepository->pushCriteria(new TasksByType($id))
                        ->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $task=$taskRepo->paginate(15,['*']);
        return view("Bentity.index",compact("bentity","tasktype","task","id","benId"));

   }



    public function create(){
        $tasktype=array_column(Tasktype::all()->sortBy('id')->toArray(),'name','id');
        return view("Bentity.create",compact("bentity","tasktype"));
    }
    //保存
    public function store(Request $request){
          $bentity=$request->all();
          $name=$request->input('name');
//        dd(Bentity::where("name",$name)->count());
        if(Bentity::where("name",$name)->count()>=1){
            Flash::success("该业务库类型配置已存在，请重新配置！");
            return redirect(route('bentity.index'));
        }else{
            Bentity::create($bentity);
            Flash::success("保存成功！");
            return redirect(route('bentity.index'));
        }

    }

    //删除
    public function destroy($id){
        $ben=Bentity::find($id);
        $ben->delete();
        Flash::success("删除成功！");
        return redirect(route('bentity.index'));
    }
    //编辑
    public function edit($id){
        $ben=Bentity::find($id);
        $tasktype=array_column(Tasktype::all()->sortBy('id')->toArray(),'name','id');
//        dd($bentitype->bentity->name);
        return view("bentity.edit",compact('ben','tasktype'));
    }
    //修改
    public function update(Request $request, $id){
        $data=$request->all();
//        dd($data);
        $name=$request->input('name');
        $tasktypes_id=$request->input('tasktypes_id');
        if(Bentity::where(["name"=>$name,"tasktypes_id"=>$tasktypes_id])->count()>1){
            Flash::success("该业务库类型配置已存在，请重新配置！");
            return redirect(route('bentity.index'));
        }else{
            $ben=Bentity::find($id);
            $ben->update($data);
            Flash::success("修改成功！");
            return redirect(route('bentity.index'));
        }
    }
//显示详情
//$id起始任务的id tag为显示全部的标识
//$benId->显示在详情上面的标题,$taskId->显示在详情上面的标题,$tag->标识
//385/2/30
  public function detail($id,$benId){
//      初始工单的信息
      $task=$this->taskRepository->findWithoutFail($id);

      if(empty($task)){
          Flash::error('Task not found');
          return redirect(route('bentity.index'));
      }
      $atts = $this->taskEavRepository;

      $eavValue = $this->taskEavValueRepository;
      //下面获取该维度的详情；它应该有一个或多个id（对应多条task）
      $tasklist= $this->bentitsetRepository->getTaskList($id);

      //在配置表里获取列 task_id;
      $taskidlist=array_column($tasklist->sortByDesc('create_at')->toArray(),'task_id','id');
//     dd($taskidlist);

      //获取配置的taskid数组列表，传过去。
      $tasks=[];
      foreach($taskidlist as $taskids){
      $tasksTmp=$this->taskRepository->findWithoutFail($taskids);
          if (!empty($tasksTmp)){
              $tasks[]=$tasksTmp;
          }
      }
//      dd($tasks);
//      $subTask=$task;
      $taskIds = array_column($task->toArray(),'id');
      $groupComments = $this->taskgroupRepository->findWhereIn('task_id',$taskIds);

      return view("bentity.show",compact("id",'groupComments','task','atts','eavValue','benId','taskId','taskidlist','tasks'));
  }
//分类详情
//{{--$tasktypelist->id 类型 $id为初始工单id 业务库id  --}}
  public function typedetail($tasktype_id,$id,$benId,$tag){
      $task=$this->taskRepository->findWithoutFail($id);

      $atts = $this->taskEavRepository;
      $eavValue = $this->taskEavValueRepository;
      $tasklist= $this->bentitsetRepository->getTaskList($id);
      $taskidlist=array_column($tasklist->sortByDesc('create_at')->toArray(),'task_id','id');
      //获取配置的taskid数组列表，传过去。
//      dd($taskidlist);
      foreach($taskidlist as $key=>$taskids){

//
          $tasksTmp=$this->taskRepository->findWhere(['id'=>$taskids , 'tasktype_id'=>$tasktype_id])->first();

//          $tasksTmp=\DB::select(" SELECT * FROM tasks
//         where tasks.id=$taskids
//          AND tasks.tasktype_id=$tasktype_id");
          if(!empty($tasksTmp)){
              $tasks[$key]=$tasksTmp;
          }

     }


      $subTask=$task;


      $taskIds = array_column($subTask->toArray(),'id');
      $groupComments = $this->taskgroupRepository->findWhereIn('task_id',$taskIds);

      return view("bentity.show",compact('id','tasklist','task','benId','tasktitle','atts','eavValue','tasks','groupComments','tag','tasktype_id'));
  }

}