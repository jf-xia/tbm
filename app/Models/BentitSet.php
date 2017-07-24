<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Taskgroup
 * @package App\Models
 * @version November 3, 2016, 12:53 pm CST
 */
class BentitSet extends Model
{
//    use SoftDeletes;

    public $table = 'bentitset';
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';

//    protected $dates = ['deleted_at'];


    public $fillable = [
        'task_id',
        'ben_title_id',

    ];

    public function task()
    {
        return $this->belongsTo(\App\Models\Task::class, 'task_id', 'id');
    }

    public function bentity()
    {
        return $this->belongsTo(\App\Models\Task::class, 'ben_title_id', 'id');
    }
//    /**
//     * The attributes that should be casted to native types.
//     *
//     * @var array
//     */
//    protected $casts = [
//        'task_id' => 'integer',
//        'user_id' => 'integer',
//        'grade' => 'string',
//        'comment' => 'string'
//    ];
//
//    /**
//     * Validation rules
//     *
//     * @var array
//     */
//    public static $rules = [
//
//    ];
//
//    public function getGradegoodAttribute()
//    {
//        $gradetype=$this->where('grade','=',1)->where('task_id','=',$this->attributes['task_id'])->count();
//        return $gradetype;
//    }
//
//    public function getGradebadAttribute()
//    {
//        $gradetype=$this->where('grade','=',2)->where('task_id','=',$this->attributes['task_id'])->count();
//        return $gradetype;
//    }
//
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     **/
//    public function task()
//    {
//        return $this->belongsTo(\App\Models\Task::class, 'task_id', 'id');
//    }
//
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     **/
//    public function user()
//    {
//        return $this->belongsTo(\App\User::class, 'user_id', 'id');
//    }
}
