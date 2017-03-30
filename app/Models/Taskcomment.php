<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Taskcomment
 * @package App\Models
 * @version November 3, 2016, 12:58 pm CST
 */
class Taskcomment extends Model
{
    use SoftDeletes;

    public $table = 'taskcomments';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'task_id',
        'user_id',
        'comment'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'task_id' => 'integer',
        'user_id' => 'integer',
        'comment' => 'string'
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

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }
}
