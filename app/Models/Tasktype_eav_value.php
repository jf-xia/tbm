<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Tasktype_eav_value
 * @package App\Models
 * @version November 3, 2016, 1:15 pm CST
 */
class Tasktype_eav_value extends Model
{
    use SoftDeletes;

    public $table = 'tasktype_eav_values';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'task_id',
        'task_type_eav_id',
        'task_value'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'task_id' => 'integer',
        'task_type_eav_id' => 'integer',
        'task_value' => 'string'
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
    public function task()
    {
        return $this->belongsTo(\App\Models\Task::class, 'task_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function tasktypeEav()
    {
        return $this->belongsTo(\App\Models\Tasktype_eav::class, 'task_id', 'id');
    }
}
