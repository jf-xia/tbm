<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Technicalsupport
 * @package App\Models
 * @version October 10, 2016, 5:59 am UTC
 */
class Technicalsupport extends Model
{

    public $table = 'gta_technical_support';

    public $primaryKey = 'q_id';

    public $fillable = [
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
        'q_remark2'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'q_id' => 'integer',
        'q_bu' => 'string',
        'q_c_id' => 'integer',
        'q_project_name' => 'string',
        'q_customer_province' => 'string',
        'q_project_id' => 'string',
        'q_sku' => 'string',
        'q_product_name' => 'string',
        'q_product_version' => 'string',
        'q_customer_from' => 'string',
        'q_customer' => 'string',
        'q_support_bu' => 'string',
        'q_type' => 'string',
        'q_s_type' => 'string',
        'q_level' => 'string',
        'q_question' => 'string',
        'q_image' => 'string',
        'q_anwser' => 'string',
        'q_customer_service' => 'string',
        'q_handler' => 'string',
        'q_email_enable' => 'string',
        'q_imp_detail' => 'string',
        'q_handle_detail' => 'string',
        'q_state' => 'string',
        'q_satisfied' => 'string',
        'q_satisfied_result' => 'string',
        'q_satisfied_service' => 'string',
        'q_satisfied_time' => 'string',
        'q_satisfied_date' => 'date',
        'q_tuidongshiyebu' => 'string',
        'q_install' => 'string',
        'q_satisfied_vist' => 'string',
        'q_remark1' => 'string',
        'q_remark2' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
