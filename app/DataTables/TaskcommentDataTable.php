<?php

namespace App\DataTables;

use App\Models\Taskcomment;
use Form;
use Yajra\Datatables\Services\DataTable;

class TaskcommentDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'taskcomments.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $taskcomments = Taskcomment::query();

        return $this->applyScopes($taskcomments);
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
            ->parameters([
                'dom' => 'Bfrtip',
                'scrollX' => true,
                'buttons' => [
                    [
                        'extend'  => 'print',
                        'text'    => trans('dt.Print'),
                    ],
                    [
                        'extend'  => 'reset',
                        'text'    => trans('dt.Reset'),
                    ],
                    [
                        'extend'  => 'reload',
                        'text'    => trans('dt.Reload'),
                    ],
                    [
                         'extend'  => 'collection',
                         'text'    => '<i class="fa fa-download"></i> '.trans('dt.Export'),
                         'buttons' => [
                             'csv',
                             'excel',
                         ],
                    ],
                    [
                        'extend'  => 'colvis',
                        'text'    => trans('dt.Column visibility'),
                    ]
                ]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'task_id' => ['name' => 'task_id', 'data' => 'task_id'],
            'grade' => ['name' => 'grade', 'data' => 'grade'],
            'comment' => ['name' => 'comment', 'data' => 'comment']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'taskcomments';
    }
}
