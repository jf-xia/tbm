<?php

namespace App\DataTables;

use App\Models\Report;
use Form;
use Yajra\Datatables\Services\DataTable;

class TasksetDataTable extends DataTable
{
    private $query;
    public $columns;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
//        \Log::debug($this->query->toSql());
        //$this->query()
        return $this->datatables
            ->queryBuilder($this->query)
            ->addColumn('action', 'tasksets.datatables_actions')
            ->make(true);
    }

    public function setQuery($query)
    {
        $this->query=$query;
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $reports = Report::query();

        return $this->applyScopes($reports);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->columns)
            ->addAction(['width' => '10%'])
            ->ajax(["dataType" => 'json', 'url'=>'','method'=>'post'])//
            ->parameters();
//        ['buttons' => [
//                [
//                    'extend'=> 'collection',
//                    'text' => trans('view.Action'),
//                    'buttons' => [
//
//                    ],
//                ]]]
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return $this->columns;
//        return [
//            'name' => ['name' => 'name', 'data' => 'name'],
//            'desc' => ['name' => 'desc', 'data' => 'desc'],
//            'rules' => ['name' => 'rules', 'data' => 'rules']
//        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'reports';
    }
}
