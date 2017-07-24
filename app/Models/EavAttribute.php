<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EavAttribute
 * @package App\Models
 * @version April 10, 2017, 5:48 pm CST
 */
class EavAttribute extends Model
{
    use SoftDeletes;

    public $table = 'eav_attributes';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'type_id',
        'code',
        'frontend_label',
        'frontend_input',
        'frontend_size',
        'is_required',
        'is_unique',
        'is_report',
        'is_public',
        'option',
        'orderby',
        'note'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'type_id' => 'integer',
        'code' => 'string',
        'frontend_label' => 'string',
        'frontend_input' => 'string',
        'option' => 'string',
        'note' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
