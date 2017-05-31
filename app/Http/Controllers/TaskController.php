<?php

namespace App\Http\Controllers;

use App\DataTables\TaskDataTable;
use App\Models\ProductMain;
use App\Models\Task;
use App\Models\Taskcomment;
use App\Models\Tasktype;
use App\Models\Upload;
use App\Models\UploadLog;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Repositories\TaskRepository;
use App\Repositories\TasktypeRepository;
use App\Repositories\TaskgroupRepository;
use App\Repositories\TaskstatusRepository;
use App\Repositories\Tasktype_eavRepository;
use App\Repositories\Tasktype_eav_valueRepository;
use App\User;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Response;
use Exception;

class TaskController extends AppBaseController
{
    /** @var  TaskRepository */
    private $taskRepository;
    private $tasktypeRepository;
    private $taskstatusRepository;
    private $taskgroupRepository;
    private $taskEavRepository;
    private $taskEavValueRepository;

    public function __construct(TaskRepository $taskRepo,
                                TasktypeRepository $tasktypeRepo,
                                Tasktype_eavRepository $taskEavRepo,
                                Tasktype_eav_valueRepository $taskEavValueRepo,
                                TaskstatusRepository $taskstatusRepo,
                                TaskgroupRepository $taskgroupRepo)
    {
        $this->taskRepository = $taskRepo;
        $this->tasktypeRepository = $tasktypeRepo;
        $this->taskstatusRepository = $taskstatusRepo;
        $this->taskgroupRepository = $taskgroupRepo;
        $this->taskEavRepository = $taskEavRepo;
        $this->taskEavValueRepository = $taskEavValueRepo;
    }

    public function test($id, Request $request)
    {
//        $upload = Excel::load('public/uploads/import/tasks/9_2017-03-07-163627.xlsx');
        \DB::enableQueryLog();
dd(\Auth::getSession()->getId(), \DB::getQueryLog());
        $test = $this->taskRepository->findWithoutFail($id);
//        $test = $this->tasktypeRepository->getUserTaskTypeList();
//        $test = $this->taskstatusRepository->findWhere(['user_id'=>0]);
//        $tags = \DB::select('select id, topic as text from tags WHERE topic LIKE :tagname', ['tagname'=>'%my%']);
        dd($test->toArray(), \DB::getQueryLog());

    }

    /**
     * Display a listing of the Task.
     *
     * @param TaskDataTable $taskDataTable
     * @return Response
     */
    public function index(TaskDataTable $taskDataTable)
    {
        $tasktype=$this->tasktypeRepository->getUserTaskTypeList();
        $selectTaskStatus = $this->taskstatusRepository->selectTaskstatus();
        return $taskDataTable->render('tasks.index',['tasktype'=>$tasktype,'selectTaskStatus'=>$selectTaskStatus]);
    }

    /**
     * Show the form for creating a new Task.
     *
     * @return Response
     */
    public function create($tasktype_id=1)
    {
        $atts = $this->taskEavRepository->taskTypeEav($tasktype_id);
        $tasktype = $this->tasktypeRepository->find($tasktype_id);
        //\App\Models\Tasktype::find($tasktype_id);
        $selectTaskstatus = $this->taskstatusRepository->selectTaskstatus();
        return view('tasks.create',compact('atts','tasktype_id','selectTaskstatus','tasktype'));
    }

    /**
     * Store a newly created Task in storage.
     *
     * @param CreateTaskRequest $request
     *
     * @return Response
     */
    public function store(CreateTaskRequest $request)
    {
        $input = $request->all();
        $authUser=\Auth::user();
        $is_assigned=isset($input['assigned_to'])&&isset($input['task_id']);

        if ($is_assigned){
            $input['user_id']=$input['assigned_to'] ? $input['assigned_to'] : $authUser->id;
            $input['informed'][]=$authUser->id;
            $assignedUser = User::all()->find($input['assigned_to']);
            if ($assignedUser) { $input['informed'][]=$assignedUser->leader; }
        } else {
            $input['user_id']=$authUser->id;
        }
        $input['informed'][]=$authUser->leader;
        $userIds=$input['informed'];
        $input['informed']=implode('|',$input['informed']);

        $task = $this->taskRepository->create($input);

        foreach($userIds as $userId){
            $groupId=$this->taskgroupRepository->findWhere(['task_id'=>$task->id,'user_id'=>$userId])->first();
            if (!$groupId){
                $this->taskgroupRepository->create(['task_id'=>$task->id,'user_id'=>$userId]);
            }
        }

        if (isset($input['attribute'])){
            $attributes = $input['attribute'];
            foreach ($attributes as $attKey=>$attValue) {
                $this->taskEavValueRepository->create(['task_id'=>$task->id,'task_type_eav_id'=>$attKey,'task_value'=>$attValue]);
            }
        }

        if ($is_assigned){
            Flash::success('Task assigned successfully.');

            $atts = $this->taskEavRepository;
            $eavValue = $this->taskEavValueRepository;
            $taskId = $task->task_id ? $task->task_id : $task->id;
            $subTask = $this->taskRepository->subTaskInfo($taskId);
            $taskIds = array_column($subTask->toArray(),'id');
            $groupComments = $this->taskgroupRepository->findWhereIn('task_id',$taskIds);

            try{
                $informed = \Mail::send('emails.task_assigned',['task'=>$task,'atts'=>$atts,'eavValue'=>$eavValue,'subTask'=>$subTask,'groupComments'=>$groupComments],function($message) use ($task) {
//                    $message->from(env('MAIL_USERNAME').env('MAIL_COM'), env('MAIL_USERNAME'));
                    $message->to($task->user->email);
                    $message->bcc('Task.system@gtafe.com');
                    $message->subject('['.$task->tasktype->name.'任务]'.$task->title);
                    foreach ($task->informed_email as $cc) {
                        $message->cc($cc);
                    }
                });
            } catch (Exception $e) {
//            throw $e;
//                \Log::warning($e);
            }

            return redirect(route('taskgroups.type',1));
        }

        $this->emailTo($task,'新建');

        Flash::success('Task saved successfully.');
        return redirect(route('tasks.show',$task->id));
    }

    public function emailTo($task,$type='新建'){

        $atts = $this->taskEavRepository;
        $eavValue = $this->taskEavValueRepository;
        $taskId = $task->task_id ? $task->task_id : $task->id;
        $subTask = 0;
        $groupComments = 0;
        if($type<>'新建'){
            $subTask = $this->taskRepository->subTaskInfo($taskId);
            $taskIds = array_column($subTask->toArray(),'id');
            $groupComments = $this->taskgroupRepository->findWhereIn('task_id',$taskIds);
        }

        try{
            $informed = \Mail::send('emails.task_new',['task'=>$task,'atts'=>$atts,'eavValue'=>$eavValue,'subTask'=>$subTask,'groupComments'=>$groupComments],function($message) use ($task,$type) {
//                $message->from(env('MAIL_USERNAME').env('MAIL_COM'),env('MAIL_USERNAME'));
                $message->to($task->user->email);
                $message->bcc('Task.system@gtafe.com');
                $message->subject('['.$task->user->name.$type.$task->tasktype->name.'任务]'.$task->title);
                foreach ($task->informed_email as $to) {
                    $message->to($to);
                }
                foreach ($task->task_owners_email as $cc) {
                    $message->cc($cc);
                }
            });
        } catch (Exception $e) {
//            throw $e;
            \Log::warning($e);
        }
    }

    public function taskCols($tasktype_id)
    {
        $atts = $this->taskEavRepository->taskTypeEav($tasktype_id);
        $task = [
            'id'=>trans('db.id'),
            'title'=>trans('db.title'),
            'hours'=>trans('db.hours'),
            'created_at'=>trans('db.created_at'),
            'end_at'=>trans('db.end_at'),
            'product_id'=>trans('db.product_id'),
            'project_id'=>trans('db.project_id'),
            'content'=>trans('db.content')
        ];
        return $data = array(array_merge($task,array_column($atts->toArray(),'frontend_label','code')));
    }

    public function importExample($tasktype_id){
        $data = $this->taskCols($tasktype_id);
        Excel::create('task'.$tasktype_id.'_'.date('Y-m-d-His'), function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromArray($data);

            });

        })->export('xls');
    }

    public function tasksUpload()
    {
        $path = 'uploads/import/tasks';
        $upload = new Upload([
            'upload_dir'=>public_path($path).'/',
            'upload_url'=>url($path).'/',
            'accept_file_types' => '/\.(xls?x|xls)$/i',
        ]);
    }

    public function import($tasktype_id)
    {
        $atts = $this->taskEavRepository->taskTypeEav($tasktype_id);
        $tasktype = $this->tasktypeRepository->find($tasktype_id);
        $uploads = UploadLog::where('user_id','=',\Auth::id())->get();
        return view('tasks.import',compact('atts','tasktype_id','tasktype','uploads'));
    }

    public function checkData(Request $request)
    {
        $input = $request->all();
        $tasktype_id=$input['tid'];
        $fileName=$input['file'];
        $checkCols = $this->taskCols($tasktype_id)[0];
        $uploadCols = array_filter(Excel::load('public/uploads/import/tasks/'.$fileName)->first()->toArray());
        if($uploadCols == $checkCols && $tasktype_id && $fileName) {//
            $upload = Excel::load('public/uploads/import/tasks/'.$fileName);
            $allData = $upload->limit(5)->toArray();
            $dataHtml = '';
            foreach($allData as $row) {
                if($row){
                    $dataHtml .= '<tr>';
                    foreach($row as $elm) {
                        $dataHtml .= '<td>'.$elm.'</td>';
                    }
                    $dataHtml .= '</tr>';
                }
            }
            echo '<div style="width:1000px;height:300px;overflow:scroll"><table width="3000" border="1"><caption>'
                .trans('view.Import').trans('view.Check').'</caption>'.$dataHtml.'</table></div>';
        } else {
            $diffCol = array_diff_assoc($checkCols,$uploadCols);
            $errorMessage = $diffCol ? '*提示: '.implode(', ',$diffCol).'字段缺失或错位' : '';
            echo '数据验证失败，请使用标准模板上传，并阅读第1、2部的上传规范。'.$errorMessage;
        }
    }

    public function deleteImportData($id)
    {
        $upload = UploadLog::find($id);

        if (empty($upload)) {
            Flash::error('Task not found');
            return redirect(route('tasks.importByTypeId',1));
//            return ['error'=>'Task not found'];
        }
        $tasktypeId = $upload->tasktype_id;
        \DB::beginTransaction();
        try{
            if ($upload->import_ids) {
                foreach(explode(',',$upload->import_ids) as $taskId){
                    $task = $this->taskRepository->findWithoutFail($taskId);
                    if (!empty($task)) $task->delete();
                }
            }
            $upload->delete();
        }catch (Exception $e) {
            \DB::rollback();
            \Log::error($e);

            Flash::error('数据删除产生严重错误，删除数据自动回滚,请手动处理');
            return redirect(route('tasks.importByTypeId',$tasktypeId));
//            return ['error'=>'数据删除产生严重错误，删除数据自动回滚,请手动处理'];
        }
        \DB::commit();

        Flash::success(trans('view.Delete').trans('view.Task').': '.$upload->import_ids);
        return redirect(route('tasks.importByTypeId',$tasktypeId));
//        return [$id=>trans('view.Delete').trans('view.Task').': '.$upload->import_ids];
    }

    public function submitImportData(Request $request)
    {
        $input = $request->all();
        $tasktype_id=$input['tid'];
        $fileName=$input['file'];
        $uploadData = Excel::load('public/uploads/import/tasks/'.$fileName)->limit(3500)->toArray();
        $upload_ids = [];
        $import_ids = [];
        $error_ids = [];
        $upload = UploadLog::where('user_id','=',\Auth::id())->where('file_name','=',$fileName)->first();
        if (empty($upload)){
            $upload = UploadLog::create(['user_id'=>\Auth::id(),'file_name'=>$fileName,'tasktype_id'=>$tasktype_id]);
            $atts = $this->taskEavRepository->taskTypeEav($tasktype_id);
            $attsKeys = array_column($atts->toArray(),'code','id');
            \DB::beginTransaction();
            foreach($uploadData as $row) {
                if ($row['id']=='编号') continue;
                $upload_ids[]=$row['id'];
                if(is_numeric($row['id'])){
                    try{
                        if ($row['product_id']) {
                            $product = \DB::selectOne("select id from p_product_info where id = :id or prod_sku = :sku",
                                ['id'=>trim($row['product_id']),'sku'=>trim($row['product_id'])]);
                            $row['product_id'] = $product ? $product->id : 0;
                        }
                        if ($row['project_id']) {
                            $project = \DB::selectOne("select project_id as id from gta_project_main where project_id = :id or project_serial = :sku", [
                                'id'=>trim($row['project_id']),'sku'=>trim($row['project_id'])]);
                            $row['project_id'] = $project ? $project->id : 0;
                        }
                        $row['hours'] = $row['hours'] ? $row['hours'] : 0.5;
                        $row['created_at'] = $row['created_at'] ? $row['created_at'] : date('Y-m-d H:i:s');
//                        \Log::debug($row);
                        $task = $this->taskRepository->create([
                            'title'=>$row['title'],
                            'hours'=>$row['hours'],
                            'created_at'=>$row['created_at'],
                            'end_at'=>$row['end_at'],
                            'product_id'=>$row['product_id'],
                            'project_id'=>$row['project_id'],
                            'content'=>$row['content'],
                            'user_id'=>\Auth::id(),
                            'tasktype_id'=>$tasktype_id,
                            'taskstatus_id'=>5
                        ]);
                        foreach ($attsKeys as $eavID=>$key) {
                            if (isset($row[$key]))
                            $this->taskEavValueRepository->create(['task_id'=>$task->id,'task_type_eav_id'=>$eavID,'task_value'=>$row[$key]]);
                        }
                    }catch (Exception $e) {
                        \DB::rollback();
//                        \Log::error($e);
                        return '编号为'.$row['id'].'的数据产生严重错误，无法导入，如无法判断问题原因，建议删除该行，再执行导入操作';
                    }
                    $import_ids[] = $task->id;
                }else{
                    $error_ids[]=$row['id'];
                }
            }
            \DB::commit();
            $result = [
                'upload_ids'=>implode(',',$upload_ids),
                'import_ids'=>implode(',',$import_ids),
                'error_ids'=>implode(',',$error_ids)
            ];
            $upload->update($result);
        } else {
            $result = [
                'upload_ids'=>$upload->upload_ids,
                'import_ids'=>$upload->import_ids,
                'error_ids'=>$upload->error_ids
            ];
        }
        return Response::json($result);
    }

    /**
     * Display the specified Task.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $task = $this->taskRepository->findWithoutFail($id);

        if (empty($task)) {
            Flash::error('Task not found');
            return redirect(route('tasks.index'));
        }
        $atts = $this->taskEavRepository;
        $eavValue = $this->taskEavValueRepository;
        $taskId = $task->task_id ? $task->task_id : $task->id;
        $subTask = $this->taskRepository->subTaskInfo($taskId);
        $taskIds = array_column($subTask->toArray(),'id');
        $groupComments = $this->taskgroupRepository->findWhereIn('task_id',$taskIds);

        return view('tasks.show',compact('task','atts','eavValue','subTask','groupComments'));
    }

    /**
     * Show the form for editing the specified Task.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $task = $this->taskRepository->findWithoutFail($id);

        if (empty($task)) {
            Flash::error('Task not found');
            return redirect(route('tasks.index'));
        }

        $selectTaskstatus = $this->taskstatusRepository->selectTaskstatus();
        $atts1 = $this->taskEavRepository->taskTypeEav($task->tasktype_id);
        $eavValue1 = $this->taskEavValueRepository->eavValue($id);

        $atts = $this->taskEavRepository;
        $eavValue = $this->taskEavValueRepository;
        $taskId = $task->task_id ? $task->task_id : $task->id;
        $subTask = $this->taskRepository->subTaskInfo($taskId);

        $taskIds = array_column($subTask->toArray(),'id');
        $groupComments = $this->taskgroupRepository->findWhereIn('task_id',$taskIds);

        return view('tasks.edit',compact('task','atts1','eavValue1','selectTaskstatus','atts','eavValue','subTask','groupComments'));
    }

    /**
     * Update the specified Task in storage.
     *
     * @param  int              $id
     * @param UpdateTaskRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTaskRequest $request)
    {
        $task = $this->taskRepository->findWithoutFail($id);
        $input = $request->all();
        if (empty($task) || $task->user_id<>\Auth::id()) {
            Flash::error('Task not found');

            return redirect(route('tasks.index'));
        }

        if (isset($input['informed'])){
            foreach($input['informed'] as $userId){
                $groupId=$this->taskgroupRepository->findWhere(['task_id'=>$id,'user_id'=>$userId])->first();
                if (!$groupId){
                    $this->taskgroupRepository->create(['task_id'=>$id,'user_id'=>$userId]);
                }
            }
            $input['informed']=implode('|',$input['informed']);
        }

        $task = $this->taskRepository->update($input, $id);

        if (isset($input['attribute'])){
            $attributes = $input['attribute'];
            foreach ($attributes as $attKey=>$attValue) {
                $attId=$this->taskEavValueRepository->findWhere(['task_id'=>$id,'task_type_eav_id'=>$attKey])->first();
                if ($attId){
                    $this->taskEavValueRepository->update(['task_id'=>$id,'task_type_eav_id'=>$attKey,'task_value'=>$attValue],$attId->id);
                }else{
                    $this->taskEavValueRepository->create(['task_id'=>$id,'task_type_eav_id'=>$attKey,'task_value'=>$attValue]);
                }
            }
        }
//        //todo email
//        if($task->taskstatus_name=='完成'){
//            $this->emailTo($task,'完成');
//        }

        Flash::success('Task updated successfully.');

        return redirect(route('tasks.show',$task->id));
    }

    /**
     * Remove the specified Task from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $task = $this->taskRepository->findWithoutFail($id);

        if (empty($task) || $task->user_id<>\Auth::id()) {
            Flash::error('Task not found');

            return redirect(route('tasks.index'));
        }

//        //todo email
//        $this->emailTo($task,'删除');

        $this->taskRepository->delete($id);

        Flash::success('Task deleted successfully.');

        return redirect(route('tasks.index'));
    }

    /**
     * @return \Illuminate\View\ajax
     */
    public function productajax(Request $request)
    {
        $input = $request->all();
        $term='%'.$input['term'].'%';//, concat(start_at,plan_at,finish_at) as descr
        $userlist = \DB::select("select id,concat(prod_name,' ',prod_version,' (',prod_sku,')') as text,concat('产品经理:',prod_manager,'; 测试经理:',test_manager,'; 开发经理:',proj_manager,'; 运维经理:',if((SELECT COUNT(*) from users WHERE id=yw_person)=0,'未分配',(SELECT name from users WHERE id=yw_person))) AS descr
 from p_product_info where prod_sku LIKE :prod_sku or `prod_name` LIKE :prod_name ORDER BY id DESC LIMIT 20", ['prod_sku'=>$term,'prod_name'=>$term]);
        return \Response::json($userlist);
    }

    public function calendar()
    {
        $myTeams = \Auth::user()->getTeams(\Auth::id(),[\Auth::id()=>\Auth::user()->name]);
        $tasktype = $this->tasktypeRepository->getUserTaskTypeList();
        $planToTasks = \DB::select($this->getTasksSql().' WHERE (hours = 0 or taskstatus_id <> 5) and deleted_at is NULL and user_id=:user_id order by end_at ASC',
            ['user_id'=>\Auth::id()]);
//        dd($tasks);
        return view('tasks.calendar',compact('myTeams','tasktype','planToTasks'));
    }

    public function createAjax(Request $request)
    {
        $input = $request->all();
        if (!isset($input['title'])){
            return 'Title cannot be empty!';
        }
        $user = \Auth::user();
        $input['user_id']=$user->id;
        $input['taskstatus_id']=1;
        $task = $this->taskRepository->create($input);
        if ($user->leader) {
            $this->taskgroupRepository->create(['task_id'=>$task->id,'user_id'=>$user->leader]);
        }

        return $task->id;
    }

    public function cloneAjax(Request $request)
    {
        $input = $request->all();
        $task = $this->taskRepository->findWithoutFail($input['id']);
        $user = \Auth::user();
        if (empty($task) || $task->user_id<>$user->id) {
            return 'Task not found';
        }
        $input = $task->toArray();
//        unset($input['id']);
        unset($input['informed']);
        unset($input['taskgroup']);
        $input['taskstatus_id']=1;
        $cloneTask = $this->taskRepository->create($input);
        if ($user->leader) {
            $this->taskgroupRepository->create(['task_id'=>$cloneTask->id,'user_id'=>$user->leader]);
        }
//        dd($cloneTask);

        return $cloneTask->id;
    }

    public function updateAjax(Request $request)
    {
        $input = $request->all();
		if (empty($input)){
            return 'Request input empty';
        }
        $task = $this->taskRepository->findWithoutFail($input['id']);
        if (empty($task) || $task->user_id<>\Auth::id()) {
            return 'Task not found';
        }
        $task = $this->taskRepository->update($input,$input['id']);

        return 'OK';
    }

    public function share($id)
    {
        $task = $this->taskRepository->findWithoutFail($id);
        if (empty($task) || $task->user_id<>\Auth::id()) {
            Flash::error('Task not found');
            return redirect(route('tasks.index'));
        }
        $price = $task->price ? 0 : 1;

        \DB::update('update tasks set price='.$price.' where id='.$id);

        Flash::success('Task updated successfully.');

        return redirect(route('tasks.show',$id));
    }

    public function listAjax(Request $request)
    {
        $input = $request->all();
//        \Log::debug(['start'=>date('Y-m-d H:i:s',$input['start']),'end'=>date('Y-m-d H:i:s',$input['end']),'user_id'=>$input['user_id']]);
        $task = \DB::select($this->getTasksSql().' WHERE end_at >=from_unixtime(:start) and end_at <=from_unixtime(:end) and user_id=:user_id and hours > 0.4 and deleted_at is NULL', ['start'=>$input['start'],'end'=>$input['end'],'user_id'=>$input['user_id']]);

//        \Log::debug($task);
        return \Response::json($task);
    }

    private function getTasksSql()
    {
        return 'SELECT id,title,hours,price,tasktype_id, CASE LEFT(title,1) WHEN \'*\' THEN \'#00c0ef\' WHEN \'!\' THEN \'#dd4b39\' WHEN \'^\' THEN \'#00a65a\' WHEN \'~\' THEN \'#3c8dbc\' ELSE \'#666\' END as color,end_at as startat,DATE_ADD(end_at,INTERVAL (hours*60) MINUTE) as endat,taskstatus_id as taskstatus,IF(hour(end_at)<6,1,0) as allday from tasks ';
    }

    public function showAjax($id)
    {
        $task = $this->taskRepository->findWithoutFail($id);

        if (empty($task)) {
            return 'Not found! The task may disabled right now!';
        }
        $atts = $this->taskEavRepository;
        $eavValue = $this->taskEavValueRepository;
        //$subTask = $this->taskRepository->subTaskInfo($task->task_id);
        $taskgroup = $this->taskgroupRepository->findWhere(['task_id'=>$id,'user_id'=>\Auth::id()])->first();
        return view('tasks.ajax_show',compact('task','atts','eavValue','taskgroup'));
    }



//        $uploadModel = new Upload();
//        $upload = $uploadModel->create();
//        $test = Excel::load('public/uploads/import/tasks/9_2017-02-28-114638.xlsx', function($file) {
//            // modify stuff
////            dd($file);
//
//        });
//        dd((array_filter($test->first()->toArray())),url('uploads/import/tasks'));

//        dd(\App\Models\Task::query()->leftJoin('tasktypes','tasks.tasktype_id','=','tasktypes.id')->leftJoin('taskstatuses','tasks.taskstatus_id','=','taskstatuses.id')->where('tasks.user_id', '=', \Auth::id())->select(['tasks.title','tasktypes.name as tasktype','taskstatuses.name as taskstatus','tasks.end_at','tasks.updated_at'])->selectRaw('DATE_FORMAT(tasks.created_at,\'%Y-%m-%d\') as created_at')->get());//->get()->first()->toArray()
//        dd(\DB::selectOne('SELECT * FROM tasks WHERE id = '.$id));


//        try{
//            $groupComment = $this->taskgroupRepository->find($id);
//        } catch (Exception $e) {
////            throw $e;
//            \Log::warning($e);
//        }

//        dd (redirect()->back()->getTargetUrl());
//
//        $user = \App\User::find(555);
//        dd($user);
//        $groupComment = $this->taskgroupRepository->findWithoutFail($id);

//        $task = $this->taskRepository->findWithoutFail($id);
//        $atts = $this->taskEavRepository;
//        $eavValue = $this->taskEavValueRepository;
//        $taskId = $task->task_id ? $task->task_id : $task->id;
//        $subTask = $this->taskRepository->subTaskInfo($taskId);
//        $taskIds = array_column($subTask->toArray(),'id');
//        $groupComments = $this->taskgroupRepository->findWhereIn('task_id',$taskIds);

//        return view('emails.task_comment',compact('groupComment'))

//
//    public function upload()
//    {
//        $file = array('image' => Input::file('image'));
//        // setting up rules
//        $rules = array('image' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
//        // doing the validation, passing post data, rules and the messages
//        $validator = Validator::make($file, $rules);
//        if ($validator->fails()) {
//            // send back to the page with the input data and errors
//            return Redirect::to('tasks/import/37')->withInput()->withErrors($validator);
//        }
//        else {
//            // checking file is valid.
//            if (Input::file('image')->isValid()) {
//                $destinationPath = 'uploads/import/tasks'; // upload path
//                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
//                $fileName = rand(11111,99999).'.'.$extension; // renameing image
//                Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
//                // sending back with message
//                Flash::success('Upload successfully');
//                return Redirect::to('tasks/import/37');
//            }
//            else {
//                // sending back with error message.
//                Flash::error('uploaded file is not valid');
//                return Redirect::to('tasks/import/37');
//            }
//        }
//    }
}
