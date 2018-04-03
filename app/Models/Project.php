<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Project
 * @package App\Models
 * @version October 28, 2016, 4:07 am UTC
 */
class Project extends Model
{
    public $fillable = [
        'id',
        'project_serial',
        'customer_name',
        'purchase_way',
        'product_name',
        'contract_id'
    ];

    public function getContractPriceAttribute()
    {
        return 0;
    }
    public function getContractBalanceAttribute()
    {
        return 0;
    }
    public function getInvoiceAttribute()
    {
        return 0;
    }

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'project_serial' => 'string',
        'customer_name' => 'string',
        'purchase_way' => 'string',
        'product_name' => 'string',
        'contract_id' => 'int'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];


    //'project_id' => 'integer',
//'ydate' => 'date',
//'project_serial' => 'string',
//'customer_name' => 'string',
//'purchase_way' => 'string',
//'product_name' => 'string',
//'contract_id' => 'string',
//'province' => 'string',
//'principal' => 'string',
//'contract_price' => 'float',
//'contract_balance' => 'float',
//'invoice' => 'float',
//'sale_apply_at' => 'date',
//'actualize_apply_at' => 'date',
//'project_type' => 'string',
//'department' => 'string',
//'bd' => 'string',
//'project_manager' => 'string',
//'dep_group' => 'string',
//'signing_at' => 'date',
//'check_at' => 'date',
//'supply_at' => 'date',
//'project_status' => 'string',
//'problem_type' => 'string',
//'problem' => 'string',
//'solution' => 'string',
//'obligation' => 'string',
//'problem_at' => 'date',
//'poster' => 'string',
//'start_at' => 'date',
//'plan_at' => 'date',
//'finish_at' => 'date',
//'intact_file' => 'string',
//'remarks' => 'string',
//'company' => 'string',
//'vaid_at' => 'date',
//'or_number' => 'string',
//'archive_at' => 'date',
//'vaid_remarks' => 'string',
//'serivce_down_at' => 'date',
//'trim' => 'date',
//'trim_reason' => 'string',
//'risk_level' => 'string',
//'process_remark' => 'string',
//'p_typet' => 'string',
//'support_status' => 'string',
//'stype' => 'string',
//'art_type' => 'string',
//'art_go' => 'string'
}
