<?php

namespace App\Repositories;

use App\Models\Technicalsupport;
use App\Repositories\BaseRepository;

class TechnicalsupportRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'q_bu',
        'q_c_id',
        'q_project_name',
        'q_customer_province',
        'q_project_id',
        'q_sku',
        'q_product_name',
        'q_product_version',
        'q_customer_from',
        'q_customer',
        'q_create_date',
        'q_support_bu',
        'q_type',
        'q_s_type',
        'q_level',
        'q_question',
        'q_image',
        'q_anwser',
        'q_customer_service',
        'q_handler',
        'q_email_enable',
        'q_imp_detail',
        'q_handle_detail',
        'q_plan_date',
        'q_update_date',
        'q_end_date',
        'q_state',
        'q_satisfied',
        'q_satisfied_result',
        'q_satisfied_service',
        'q_satisfied_time',
        'q_satisfied_date',
        'q_tuidongshiyebu',
        'q_install',
        'q_satisfied_vist',
        'q_remark1',
        'q_remark2',
        'q_saleisout',
        'q_buyisout',
        'q_issign',
        'q_newtime',
        'q_money'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Technicalsupport::class;
    }
}
