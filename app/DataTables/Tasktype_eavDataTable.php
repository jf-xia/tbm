<?php

namespace App\DataTables;

use App\Models\Tasktype_eav;
use Form;
use Yajra\Datatables\Services\DataTable;

class Tasktype_eavDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'tasktype_eavs.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $tasktypeEavs = Tasktype_eav::query();

        return $this->applyScopes($tasktypeEavs);
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
                'dom' => 'Blfrtip',
                'lengthMenu' => [[10, 50, 100, -1], [10, 50, 100, "All"]],
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
                        'extend'  => 'excel',
                        'text'    => '<i class="fa fa-download"></i> '.trans('dt.Export').'Excel',
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
            'tasktype_id' => ['name' => 'tasktype_id', 'data' => 'tasktype_id'],
            'code' => ['name' => 'code', 'data' => 'code'],
            'frontend_label' => ['name' => 'frontend_label', 'data' => 'frontend_label'],
            'frontend_input' => ['name' => 'frontend_input', 'data' => 'frontend_input'],
            'frontend_size' => ['name' => 'frontend_size', 'data' => 'frontend_size'],
            'is_required' => ['name' => 'is_required', 'data' => 'is_required'],
            'is_unique' => ['name' => 'is_unique', 'data' => 'is_unique'],
            'option' => ['name' => 'option', 'data' => 'option'],
            'user_id' => ['name' => 'user_id', 'data' => 'user_id'],
            'note' => ['name' => 'note', 'data' => 'note']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'tasktypeEavs';
    }
}
