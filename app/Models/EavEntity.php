<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EavEntity
 * @package App\Models
 * @version April 10, 2017, 5:52 pm CST
 */
class EavEntity extends Model
{
    use SoftDeletes;

    public $table = 'eav_entity';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'price',
        'user_id',
        'status_id',
        'type_id',
        'company_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'price' => 'integer',
        'user_id' => 'integer',
        'status_id' => 'integer',
        'type_id' => 'integer',
        'company_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
