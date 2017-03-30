<?php

namespace App\DataTables;

use App\Models\Task;
use Form;
use Yajra\Datatables\Services\DataTable;

class TaskDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query()->leftJoin('tasktypes','tasks.tasktype_id','=','tasktypes.id')->leftJoin('taskstatuses','tasks.taskstatus_id','=','taskstatuses.id')->where('tasks.user_id', '=', \Auth::id())->select(['tasks.id','tasks.title','tasktypes.name as tasktype','taskstatuses.name as taskstatus','tasks.end_at','tasks.created_at','tasks.updated_at']))
            ->addColumn('action', 'tasks.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $tasks = Task::query();

        return $this->applyScopes($tasks);
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
            'title' => ['name' => 'title', 'data' => 'title'],
            'created_at' => ['name' => 'tasks.created_at', 'data' => 'created_at'],
            'updated_at' => ['name' => 'tasks.updated_at', 'data' => 'updated_at'],
            'end_at' => ['name' => 'end_at', 'data' => 'end_at'],
            'taskstatus' => ['name' => 'taskstatuses.name', 'data' => 'taskstatus','class'=>'taskstatus_id'],
            'tasktype' => ['name' => 'tasktypes.name', 'data' => 'tasktype','class'=>'tasktype_id']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'tasks';
    }
}
