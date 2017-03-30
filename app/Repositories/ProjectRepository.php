<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\BaseRepository;

class ProjectRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ydate',
        'project_serial',
        'customer_name',
        'purchase_way',
        'product_name',
        'contract_id',
        'province',
        'principal',
        'contract_price',
        'contract_balance',
        'invoice',
        'sale_apply_at',
        'actualize_apply_at',
        'project_type',
        'department',
        'bd',
        'project_manager',
        'dep_group',
        'signing_at',
        'check_at',
        'supply_at',
        'project_status',
        'problem_type',
        'problem',
        'solution',
        'obligation',
        'problem_at',
        'update_at',
        'poster',
        'start_at',
        'plan_at',
        'finish_at',
        'intact_file',
        'remarks',
        'company',
        'vaid_at',
        'or_number',
        'archive_at',
        'vaid_remarks',
        'serivce_down_at',
        'trim',
        'trim_reason',
        'risk_level',
        'process_remark',
        'p_typet',
        'support_status',
        'stype',
        'art_type',
        'art_go'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Project::class;
    }
}
