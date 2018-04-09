<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\DataTables\TasksetDataTable;
use App\Http\Requests;
use App\Repositories\TaskRepository;
use App\Repositories\TasktypeRepository;
use App\Repositories\TaskgroupRepository;
use App\Repositories\TaskstatusRepository;
use App\Repositories\Tasktype_eavRepository;
use App\Repositories\Tasktype_eav_valueRepository;
use Illuminate\Support\Facades\DB;
use Response;

class TasksetController extends AppBaseController
{
    private $taskRepository;
    private $tasktypeRepository;
    private $taskstatusRepository;
    private $taskgroupRepository;
    private $taskEavRepository;
    private $taskEavValueRepository;
    private $taskEavCol = [];

    public function __construct(
        TaskRepository $taskRepo,
        TasktypeRepository $tasktypeRepo,
        Tasktype_eavRepository $taskEavRepo,
        Tasktype_eav_valueRepository $taskEavValueRepo,
        TaskstatusRepository $taskstatusRepo,
        TaskgroupRepository $taskgroupRepo
    ) {
        $this->taskRepository = $taskRepo;
        $this->tasktypeRepository = $tasktypeRepo;
        $this->taskstatusRepository = $taskstatusRepo;
        $this->taskgroupRepository = $taskgroupRepo;
        $this->taskEavRepository = $taskEavRepo;
        $this->taskEavValueRepository = $taskEavValueRepo;
    }

    public function task($tasktypeId, TasksetDataTable $reportDataTable)
    {
//        $tasktyleList = $this->tasktypeRepository->getUserTaskTypeList();
        $input = $reportDataTable->request();
        $tasktype = $this->tasktypeRepository->findWithoutFail($tasktypeId);
        $reportSql = $this->getReportSql($tasktype);
        $taskCol = [
            'title'=>['name'=>'title','data'=>'title','title'=>trans('db.title')],
            'user_name'=>['name'=>'user_name','data'=>'user_name','title'=>trans('db.user_id'),'searchable'=>false,"visible"=> false],
            'updated_at'=>['name'=>'updated_at','data'=>'updated_at','title'=>trans('db.updated_at'),"visible"=> false],
            'end_at'=>['name'=>'end_at','data'=>'end_at','title'=>trans('db.end_at')],
            //'assigned_to'=>['name'=>'assigned_to','data'=>'assigned_to','title'=>trans('db.assigned_to')],
            'taskstatus_id'=>['name'=>'taskstatus_id','data'=>'taskstatus_id','title'=>trans('db.taskstatus_id')],
            'hours'=>['name'=>'hours','data'=>'hours','title'=>trans('db.hours'),"visible"=> false],
            //'price'=>['name'=>'price','data'=>'price','title'=>trans('db.price'),"visible"=> false],
            'content'=>['name'=>'content','data'=>'content','title'=>trans('db.content'),"visible"=> false]
        ];
        $reportDataTable->columns = array_merge(['created_at'=>['name'=>'created_at','data'=>'created_at','title'=>trans('db.created_at'),"visible"=> false]],$this->taskEavCol,$taskCol);
//        dd($reportDataTable->columns);
        if ($input->ajax()) {
            $report = DB::table('tasks')->select(DB::raw($reportSql))->where('tasks.tasktype_id', '=', $tasktypeId)->whereNull('tasks.deleted_at');
//            \Log::debug($report->toSql());
            $reportDataTable->setQuery($report);
        }
        return $reportDataTable->render('tasksets.index', ['tasktype_id'=>$tasktypeId,'tasktype'=>$tasktype]);
    }

    public function getReportSql($tasktype)
    {
        $sql = "tasks.title,";
        if (!empty($tasktype)) {
            $sql .= $this->getEavValueSql($tasktype->id, '=tasks.id');
            $firstTask = DB::selectOne("SELECT tasktype_id FROM tasks WHERE id = (SELECT task_id FROM tasks WHERE tasktype_id=" . $tasktype->id . " LIMIT 1)");
//            dd($firstTask->tasktype_id,$tasktype->id,"SELECT tasktype_id FROM tasks WHERE id = (SELECT task_id FROM tasks WHERE tasktype_id=" . $tasktype->id . " LIMIT 1)");
            $sql .= $firstTask ? $this->getEavValueSql($firstTask->tasktype_id, '=tasks.task_id') : '';
        }

        $sql.="(SELECT users.name FROM users WHERE users.id=tasks.user_id) as 'user_name',(SELECT taskstatuses.name FROM taskstatuses WHERE taskstatuses.id=tasks.taskstatus_id) as 'taskstatus_id',tasks.hours,tasks.price,DATE_FORMAT(tasks.created_at,'%Y-%m-%d') as created_at,DATE_FORMAT(tasks.updated_at,'%Y-%m-%d') as updated_at,tasks.end_at,tasks.id,tasks.task_id,tasks.user_id,tasks.content";
        return $sql;
    }

    public function getEavValueSql($taskType, $fromTaskId)
    {
        $evSql='';
        if ($taskType) {
            foreach ($this->taskEavRepository->taskTypeEav($taskType) as $att) {
                $sqlEavValue="(SELECT task_value from tasktype_eav_values WHERE task_type_eav_id=".$att->id." and task_id".$fromTaskId." limit 1)";
//                dd(!$att->not_list);
                $this->taskEavCol[$att->code]=['name'=>$att->code,'data'=>$att->code,'title'=>$att->frontend_label,'searchable'=>false,"visible"=> !$att->not_list];
                if ($att->frontend_input=='textarea') {
                    $this->taskEavCol[$att->code]["visible"]=false;
                } elseif ($att->frontend_input=='image') {
                    $this->taskEavCol[$att->code]=['name'=>$att->code,'data'=>$att->code,'title'=>$att->frontend_label,'searchable'=>false,'render' => '"<img src=\""+data+"\" height=\"150\"/>"','exportable'=>true,"visible"=> !$att->not_list];
                } elseif ($att->frontend_input=='select2users') {
                    $sqlEavValue= '(SELECT users.name FROM users WHERE users.id='.$sqlEavValue.')';
                }
                $evSql.=$sqlEavValue." as '".$att->code."',";
            }
        }
        return $evSql;
    }

    public function index()
    {
        $tasktype = array_keys($this->tasktypeRepository->getUserTaskTypeList()) ;
        $tasktype = isset($tasktype[0]) ? $tasktype[0] :1;
        return redirect(route('reports.task', $tasktype));
    }

}
