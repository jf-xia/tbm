<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Tasktype_eav
 * @package App\Models
 * @version November 3, 2016, 1:12 pm CST
 */
class Tasktype_eav extends Model
{
    use SoftDeletes;

    public $table = 'tasktype_eavs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'tasktype_id',
        'code',
        'frontend_label',
        'frontend_input',
        'frontend_size',
        'is_required',
        'is_unique',
        'is_report',
        'not_list',
        'option',
        'user_id',
        'orderby',
        'note'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'tasktype_id' => 'integer',
        'code' => 'string',
        'frontend_label' => 'string',
        'frontend_input' => 'string',
        'frontend_size' => 'integer',
        'is_required' => 'integer',
        'is_unique' => 'integer',
        'is_report' => 'integer',
        'not_list' => 'integer',
        'option' => 'string',
        'orderby' => 'integer',
        'user_id' => 'integer',
        'note' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function tasktype()
    {
        return $this->belongsTo(\App\Models\Tasktype::class, 'tasktype_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }
}
