<?php

namespace App\DataTables;

use App\Models\Project;
use Form;
use Yajra\Datatables\Services\DataTable;

class ProjectDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'projects.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $projects = Project::query();

        return $this->applyScopes($projects);
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
            'project_serial' => ['name' => 'project_serial', 'data' => 'project_serial'],
            'customer_name' => ['name' => 'customer_name', 'data' => 'customer_name'],
            'purchase_way' => ['name' => 'purchase_way', 'data' => 'purchase_way'],
            'product_name' => ['name' => 'product_name', 'data' => 'product_name'],
            'contract_id' => ['name' => 'contract_id', 'data' => 'contract_id'],
            'project_type' => ['name' => 'project_type', 'data' => 'project_type'],
            'department' => ['name' => 'department', 'data' => 'department']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'projects';
    }
}
