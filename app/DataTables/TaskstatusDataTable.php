<?php

namespace App\DataTables;

use App\Models\Taskstatus;
use Form;
use Yajra\Datatables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder;

class TaskstatusDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        $user = \Auth::user();
        $builder=$this->query();
        if(!$user->isAdmin()){
            $builder=$builder->where('user_id', '=', 0)->orWhere('user_id', '=', $user->id)->orWhere('user_id', '=', $user->leader);
        }
        return $this->datatables
            ->eloquent($builder)
            ->addColumn('action', 'taskstatuses.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $taskstatuses = Taskstatus::query();

        return $this->applyScopes($taskstatuses);
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
            'name' => ['name' => 'name', 'data' => 'name'],
            'color' => ['name' => 'color', 'data' => 'color'],
            'user_id' => ['name' => 'user_id', 'data' => 'user_id']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'taskstatuses';
    }
}
