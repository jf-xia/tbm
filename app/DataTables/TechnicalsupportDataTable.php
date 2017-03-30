<?php

namespace App\DataTables;

use App\Models\Technicalsupport;
use Form;
use Yajra\Datatables\Services\DataTable;

class TechnicalsupportDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'technicalsupports.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $technicalsupports = Technicalsupport::query();

        return $this->applyScopes($technicalsupports);
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
            'q_bu' => ['name' => 'q_bu', 'data' => 'q_bu'],
            'q_c_id' => ['name' => 'q_c_id', 'data' => 'q_c_id'],
            'q_project_name' => ['name' => 'q_project_name', 'data' => 'q_project_name'],
            'q_customer_province' => ['name' => 'q_customer_province', 'data' => 'q_customer_province'],
            'q_project_id' => ['name' => 'q_project_id', 'data' => 'q_project_id'],
            'q_sku' => ['name' => 'q_sku', 'data' => 'q_sku'],
            'q_product_name' => ['name' => 'q_product_name', 'data' => 'q_product_name'],
            'q_product_version' => ['name' => 'q_product_version', 'data' => 'q_product_version'],
            'q_customer_from' => ['name' => 'q_customer_from', 'data' => 'q_customer_from'],
            'q_customer' => ['name' => 'q_customer', 'data' => 'q_customer'],
            'q_create_date' => ['name' => 'q_create_date', 'data' => 'q_create_date'],
            'q_support_bu' => ['name' => 'q_support_bu', 'data' => 'q_support_bu'],
            'q_type' => ['name' => 'q_type', 'data' => 'q_type'],
            'q_s_type' => ['name' => 'q_s_type', 'data' => 'q_s_type'],
            'q_level' => ['name' => 'q_level', 'data' => 'q_level']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'technicalsupports';
    }
}
