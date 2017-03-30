<?php

namespace App\DataTables;

use App\Models\Taskgroupview;
use Form;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Services\DataTable;

class TaskgroupDataTable extends DataTable
{
    //0为显示主线任务，1为显示分支任务，2为显示待评价任务,3为显示我的好评，4为显示我的吐槽
    private $showType=5;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
//        $rawSql = '`taskgroups`.`id` AS `id`,`tasks`.`title` AS `title`,(select `taskstatuses`.`name` from `taskstatuses` where (`taskstatuses`.`id` = `tasks`.`taskstatus_id`)) AS `taskstatus`,(select `tasktypes`.`name` from `tasktypes` where (`tasktypes`.`id` = `tasks`.`tasktype_id`)) AS `tasktype`,(select `users`.`name` from `users` where (`users`.`id` = `tasks`.`user_id`)) AS `users`,(select `gta_project_main`.`customer_name` from `gta_project_main` where (`gta_project_main`.`project_id` = `tasks`.`project_id`)) AS `project`,`tasks`.`content` AS `content`,`tasks`.`hours` AS `hours`,`tasks`.`price` AS `price`,`tasks`.`end_at` AS `end_at`,`tasks`.`created_at` AS `created_at`,`tasks`.`updated_at` AS `updated_at`,`tasks`.`deleted_at` AS `deleted_at`,`tasks`.`task_id` AS `task_id`,`tasks`.`user_id` AS `task_user_id`,`tasks`.`taskstatus_id` AS `taskstatus_id`,`tasks`.`tasktype_id` AS `tasktype_id`,`tasks`.`assigned_to` AS `assigned_to`,`tasks`.`project_id` AS `project_id`,`tasks`.`id` AS `taskid`,`taskgroups`.`user_id` AS `user_id`,`taskgroups`.`grade` AS `grade`,`taskgroups`.`comment` AS `comment`';
//        $query = DB::table('taskgroups')->leftJoin('tasks','taskgroups.task_id','=','tasks.id')->select(DB::raw($rawSql))->whereNull('taskgroups.deleted_at');  //$this->query();
        $query = DB::table('v_taskgroups')->where('user_id', '=', \Auth::id());
//        \Log::debug($query->toSql());
        if ($this->showType==0){
            $query=$query->whereNull('task_id');
        }elseif ($this->showType==1){
            $query=$query->whereNotNull('task_id');
        }elseif ($this->showType==2){
            $query=$query->where('grade','=',0)->where('taskstatus_id','=',5);
        }elseif ($this->showType==3){
            $query=$query->where('grade','=',1);
        }elseif ($this->showType==4){
            $query=$query->where('grade','=',2);
        }
        return $this->datatables
            ->queryBuilder($query)
            ->addColumn('action', 'taskgroups.datatables_actions')
            ->make(true);
    }

    public function setShowType($type)
    {
        return $this->showType = $type;
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $taskgroups = Taskgroupview::query();

        return $this->applyScopes($taskgroups);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->addAction(['width' => '10%'])
            ->ajax('')
            ->parameters();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'id'=>['className'=>'details-control',"orderable"=>false,'name'=>'id','data'=>'taskid','defaultContent'=>''],
//            'id'=>['name'=>'id','data'=>'id'],
            'title'=>['name'=>'title','data'=>'title','searchable'=>false],
//            'content'=>['name'=>'content','data'=>'content',"visible"=> false],
            'updated_at'=>['name'=>'updated_at','data'=>'updated_at',"defaultOrder" => true,"sortOrder" => 'desc'],
            'created_at'=>['name'=>'created_at','data'=>'created_at',"visible"=> false],
            'end_at'=>['name'=>'end_at','data'=>'end_at',"visible"=> false],
            'taskstatus'=>['name'=>'taskstatus','data'=>'taskstatus'],
            'tasktype'=>['name'=>'tasktype','data'=>'tasktype'],
            'users'=>['name'=>'users','data'=>'users'],
//            'assigned'=>['name'=>'assigned','data'=>'assigned','searchable'=>false],
            'project'=>['name'=>'project','data'=>'project',"visible"=> false],
            'hours'=>['name'=>'hours','data'=>'hours',"visible"=> false],
            'price'=>['name'=>'price','data'=>'price',"visible"=> false],
            'comment'=>['name'=>'comment','data'=>'comment',"visible"=> false],
//            'deleted_at'=>['name'=>'deleted_at','data'=>'deleted_at'],
//            'task_id'=>['name'=>'task_id','data'=>'task_id'],
//            'user_id'=>['name'=>'user_id','data'=>'user_id'],
//            'taskstatus_id'=>['name'=>'taskstatus_id','data'=>'taskstatus_id'],
//            'tasktype_id'=>['name'=>'tasktype_id','data'=>'tasktype_id'],
//            'assigned_to'=>['name'=>'assigned_to','data'=>'assigned_to'],
//            'project_id'=>['name'=>'project_id','data'=>'project_id'],
//            'taskid'=>['name'=>'taskid','data'=>'taskid']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'taskgroups';
    }
}
