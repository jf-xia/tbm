<?php

namespace App\Http\Controllers;

use App\DataTables\ReportDataTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CreateReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Repositories\ReportRepository;
use App\Repositories\UserRepository;
use App\Repositories\TaskRepository;
use App\Repositories\TasktypeRepository;
use App\Repositories\TaskgroupRepository;
use App\Repositories\TaskstatusRepository;
use App\Repositories\Tasktype_eavRepository;
use App\Repositories\Tasktype_eav_valueRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Response;

class ReportController extends AppBaseController
{
    /** @var  ReportRepository */
    private $reportRepository;
    private $taskRepository;
    private $tasktypeRepository;
    private $taskstatusRepository;
    private $taskgroupRepository;
    private $taskEavRepository;
    private $taskEavValueRepository;
    private $taskEavCol = [];

    public function __construct(
        ReportRepository $reportRepo,
                                TaskRepository $taskRepo,
                                TasktypeRepository $tasktypeRepo,
                                Tasktype_eavRepository $taskEavRepo,
                                Tasktype_eav_valueRepository $taskEavValueRepo,
                                TaskstatusRepository $taskstatusRepo,
                                TaskgroupRepository $taskgroupRepo
    ) {
        $this->reportRepository = $reportRepo;
        $this->taskRepository = $taskRepo;
        $this->tasktypeRepository = $tasktypeRepo;
        $this->taskstatusRepository = $taskstatusRepo;
        $this->taskgroupRepository = $taskgroupRepo;
        $this->taskEavRepository = $taskEavRepo;
        $this->taskEavValueRepository = $taskEavValueRepo;
    }

    public function task($tasktype=1, ReportDataTable $reportDataTable)
    {
        $tasktyleList = $this->tasktypeRepository->getUserTaskTypeList();

        $this->taskEavCol = [
            'title'=>['name'=>'title','data'=>'title','title'=>trans('db.title')],
            'user_name'=>['name'=>'user_name','data'=>'user_name','title'=>trans('db.user_id'),'searchable'=>false],
            'updated_at'=>['name'=>'updated_at','data'=>'updated_at','title'=>trans('db.updated_at')],
            'created_at'=>['name'=>'created_at','data'=>'created_at','title'=>trans('db.created_at'),],
            'end_at'=>['name'=>'end_at','data'=>'end_at','title'=>trans('db.end_at')],
            //'assigned_to'=>['name'=>'assigned_to','data'=>'assigned_to','title'=>trans('db.assigned_to')],
            'taskstatus_id'=>['name'=>'taskstatus_id','data'=>'taskstatus_id','title'=>trans('db.taskstatus_id')],
            // 'project_serial'=>['name'=>'project_serial','data'=>'project_serial','title'=>trans('db.project_serial'),'searchable'=>false],
            // 'customer_name'=>['name'=>'customer_name','data'=>'customer_name','title'=>trans('db.customer_name'),'searchable'=>false],
            'hours'=>['name'=>'hours','data'=>'hours','title'=>trans('db.hours')],
            //'price'=>['name'=>'price','data'=>'price','title'=>trans('db.price')],
            'content'=>['name'=>'content','data'=>'content','title'=>trans('db.content'),"visible"=> false]
//            ,'id'=>['name'=>'id','data'=>'id','title'=>trans('db.id')],
//            'task_id'=>['name'=>'task_id','data'=>'task_id','title'=>trans('db.task_id')]
        ];
        $input = $reportDataTable->request();
        $reportSql = $this->getReportSql($tasktype);
        $reportDataTable->columns = $this->taskEavCol;
//dd(($reportSql));
        if ($input->ajax()) {
            $report = DB::table('tasks')->select(DB::raw($reportSql))->where('tasks.tasktype_id', '=', $tasktype)->whereNull('tasks.deleted_at');//->take($input->get('length'))->skip($input->get('start'));
//            $report=DB::select("select ".$reportSql." from `tasks` where `tasks`.`tasktype_id` = ".$tasktype." and `tasks`.`deleted_at` is null  ");
//            \Log::debug($report->toSql());

//            if ($tasktype==1) {
//                $report=$report->whereIn('user_id', array_keys(\Auth::user()->getTeams(\Auth::id(), [\Auth::id()=>\Auth::user()->name])));
//            }
            $reportDataTable->setQuery($report);
        }

        return $reportDataTable->render('reports.index', ['tasktype'=>$tasktyleList,'tasktype_id'=>$tasktype]);
    }

    public function getReportSql($tasktype)
    {
        $sql = "tasks.title,(SELECT users.name FROM users WHERE users.id=tasks.user_id) as 'user_name',(SELECT users.name FROM users WHERE users.id=tasks.assigned_to) as 'assigned_to',(SELECT taskstatuses.name FROM taskstatuses WHERE taskstatuses.id=tasks.taskstatus_id) as 'taskstatus_id',";//(SELECT gta_project_main.project_serial FROM gta_project_main WHERE projects.id=tasks.project_id) as 'project_serial',(SELECT gta_project_main.customer_name FROM gta_project_main WHERE projects.id=tasks.project_id) as 'customer_name',

        $tasktype = $this->tasktypeRepository->findWithoutFail($tasktype);
        if (!empty($tasktype)) {
            $tasktype_id = $tasktype->id;
            $sql .= $this->getEavValueSql($tasktype_id, '=tasks.id');
            $subTasksTypes = DB::select('SELECT t2.tasktype_id FROM tasks as t2 WHERE t2.task_id =  (SELECT t3.task_id FROM tasks as t3 WHERE t3.tasktype_id='.$tasktype_id.' LIMIT 1) GROUP BY t2.tasktype_id ');
            foreach ($subTasksTypes as $subTasksType) {
                $sql .= $this->getEavValueSql($subTasksType->tasktype_id, ' in (SELECT t3.id from tasks as t3 where t3.task_id=tasks.task_id) ');
            }
            // dd($subTasksTypes);
            // $firstTask = DB::selectOne("SELECT tasktype_id FROM tasks WHERE id = (SELECT task_id FROM tasks WHERE tasktype_id=" . $tasktype . " LIMIT 1)");
            // $sql .= $firstTask ? $this->getEavValueSql($firstTask->tasktype_id, 'tasks.task_id') : '';

            // $lastTask = DB::selectOne("SELECT tasktype_id  FROM tasks WHERE task_id = (SELECT id FROM tasks WHERE id = (SELECT task_id FROM tasks WHERE tasktype_id=" . $tasktype . " LIMIT 1)) ORDER BY id DESC LIMIT 1");
            // $sql .= $lastTask ? $this->getEavValueSql($lastTask->tasktype_id, '(select MAX(id) FROM tasks as lasttask WHERE lasttask.task_id=tasks.task_id)') : '';
        }

        $sql.="tasks.hours,tasks.price,DATE_FORMAT(tasks.created_at,'%Y-%m-%d') as created_at,DATE_FORMAT(tasks.updated_at,'%Y-%m-%d') as updated_at,tasks.end_at,tasks.id,tasks.task_id,tasks.user_id,tasks.content";
        // FROM tasks WHERE tasks.tasktype_id=".$tasktype." and tasks.deleted_at is NULL
        return $sql;
    }

    public function getEavValueSql($taskType, $fromTaskId)
    {
        $evSql='';
        if ($taskType) {
            foreach ($this->taskEavRepository->taskTypeEav($taskType) as $att) {
                $sqlEavValue="(SELECT task_value from tasktype_eav_values WHERE task_type_eav_id=".$att->id." and task_id".$fromTaskId." limit 1)";
                $this->taskEavCol[$att->code]=['name'=>$att->code,'data'=>$att->code,'title'=>$att->frontend_label,'searchable'=>false];
                if ($att->frontend_input=='textarea') {
                    $this->taskEavCol[$att->code]["visible"]=false;
                } elseif ($att->frontend_input=='select2users') {
                    $sqlEavValue= '(SELECT users.name FROM users WHERE users.id='.$sqlEavValue.')';
                }
                $evSql.=$sqlEavValue." as '".$att->code."',";
            }
        }
        return $evSql;
    }

    /**
     * Display a listing of the Report.
     *
     * @param ReportDataTable $reportDataTable
     * @return Response
     */
    public function index()
    {
        $tasktype = array_keys($this->tasktypeRepository->getUserTaskTypeList()) ;
        $tasktype = isset($tasktype[0]) ? $tasktype[0] :1;
        return redirect(route('reports.task', $tasktype));
        //return view('reports.index');
    }

    /*
     * todo 产品和项目维度数据分析
     * -- SELECT tasks.product_id,p_product_info.prod_name,Count(tasks.id) FROM tasks INNER JOIN p_product_info ON p_product_info.id = tasks.product_id WHERE tasks.deleted_at is NULL GROUP BY product_id ORDER BY count(id) DESC
     * -- SELECT tasks.product_id,gta_project_main.customer_name,Count(tasks.id) FROM tasks INNER JOIN gta_project_main ON projects.id = tasks.project_id WHERE tasks.deleted_at is NULL GROUP BY tasks.project_id ORDER BY count(id) DESC
    */
    public function chart(Request $request)
    {
        $input = $request->all();
        if (!$input) {
            $input['from'] = date("Y-m-d", (time()-3600*24*7)).' 00:00:00';
            $input['to'] = date("Y-m-d H:m:s", time());
        }
        $tasktyleList = $this->tasktypeRepository->getUserTaskTypeList();

        $reportsStatistics=[];
        $myTeams=[];
        if ($tasktyleList) {
            $reportsStatistics['departmentReportsStatistics'] = $this->reportRepository->tasksByTypes($tasktyleList, $input['from'], $input['to']);
            $myTeams = \Auth::user()->getTeams(\Auth::id(), [\Auth::id()=>\Auth::user()->name]);
            $reportsStatistics['teamReportsStatistics'] = $this->reportRepository->tasksByUserValue(array_keys($myTeams), $input['from'], $input['to']);
            foreach ($myTeams as $userId=>$name) {
                $reportsStatistics['reportsStatistics'.'_'.$userId] = $this->reportRepository->tasksByTypesUser($tasktyleList, $userId, $input['from'], $input['to']);
            }
        }
        $taskMonthAnalyic = $this->reportRepository->monthAnalyic($tasktyleList);
//        dd($taskMonthAnalyic);
        return view('reports.chart', [
            'reportsStatistics'=>$reportsStatistics,
            'myTeams'=>($myTeams),
            'input'=>$input
            ,'taskMonthAnalyic'=>$taskMonthAnalyic
        ]);
    }

    /**
     * Show the form for creating a new Report.
     *
     * @return Response
     */
    public function create()
    {
        return view('reports.create');
    }

    /**
     * Store a newly created Report in storage.
     *
     * @param CreateReportRequest $request
     *
     * @return Response
     */
    public function store(CreateReportRequest $request)
    {
        $input = $request->all();

        $report = $this->reportRepository->create($input);

        Flash::success('Report saved successfully.');

        return redirect(route('reports.index'));
    }

    /**
     * Display the specified Report.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $report = $this->reportRepository->findWithoutFail($id);

        if (empty($report)) {
            Flash::error('Report not found');

            return redirect(route('reports.index'));
        }

        return view('reports.show')->with('report', $report);
    }

    /**
     * Show the form for editing the specified Report.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $report = $this->reportRepository->findWithoutFail($id);

        if (empty($report)) {
            Flash::error('Report not found');

            return redirect(route('reports.index'));
        }

        return view('reports.edit')->with('report', $report);
    }

    /**
     * Update the specified Report in storage.
     *
     * @param  int              $id
     * @param UpdateReportRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReportRequest $request)
    {
        $report = $this->reportRepository->findWithoutFail($id);

        if (empty($report)) {
            Flash::error('Report not found');

            return redirect(route('reports.index'));
        }

        $report = $this->reportRepository->update($request->all(), $id);

        Flash::success('Report updated successfully.');

        return redirect(route('reports.index'));
    }

    /**
     * Remove the specified Report from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $report = $this->reportRepository->findWithoutFail($id);

        if (empty($report)) {
            Flash::error('Report not found');

            return redirect(route('reports.index'));
        }

        $this->reportRepository->delete($id);

        Flash::success('Report deleted successfully.');

        return redirect(route('reports.index'));
    }
}


//    public function task($tasktype=null,ReportDataTable $reportDataTable)
//    {
//        $sql = "SELECT tasks.title as '标题',
//                (SELECT users.name FROM users WHERE users.id=tasks.user_id) as '责任人',
//                (SELECT users.name FROM users WHERE users.id=tasks.assigned_to) as '对接人',
//                (SELECT taskstatuses.name FROM taskstatuses WHERE taskstatuses.id=tasks.taskstatus_id) as '状态',
//                (SELECT gta_project_main.project_serial FROM gta_project_main WHERE projects.id=tasks.project_id) as '项目编号',
//                (SELECT gta_project_main.customer_name FROM gta_project_main WHERE projects.id=tasks.project_id) as '项目名称',";
//        foreach ($this->taskEavRepository->taskTypeEav($tasktype) as $att) {
//            $sql.="(SELECT task_value from tasktype_eav_values WHERE task_type_eav_id=".$att->id." and task_id=tasks.id) as '".$att->frontend_label."',";
//        }
//        $sql.="tasks.hours as '工时',tasks.price as '价值',tasks.created_at as '开始',tasks.updated_at as '更新',tasks.end_at as '结束',tasks.id,tasks.task_id FROM tasks WHERE tasks.tasktype_id=".$tasktype." and tasks.deleted_at is NULL";
//
//        $report = \DB::select($sql);
//        dd($report);
//        $reportDataTable->setQuery($report);
//        return $reportDataTable->render('reports.index');
//    }
