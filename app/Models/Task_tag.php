<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Task_tag
 * @package App\Models
 * @version February 14, 2017, 3:33 pm CST
 */
class Task_tag extends Model
{

    public $table = 'task_tags';

    public $fillable = [
        'tag_id',
        'task_id',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'tag_id' => 'integer',
        'task_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'tag_id' => 'required',
        'task_id' => 'required',
        'user_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function tag()
    {
        return $this->hasOne(\App\Models\Tag::class, 'tag_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function task()
    {
        return $this->hasOne(\App\Models\Task::class, 'task_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }
}
