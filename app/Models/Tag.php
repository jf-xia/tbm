<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Tag
 * @package App\Models
 * @version February 14, 2017, 3:34 pm CST
 */
class Tag extends Model
{

    public $table = 'tags';
    

    public $fillable = [
        'topic',
        'parentid',
        'direction',
        'sort'
    ];

    protected $hidden = ['created_at', 'updated_at', 'sort'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'topic' => 'string',
        'parentid' => 'integer',
        'direction' => 'integer',
        'sort' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'topic' => 'required',
        'parentid' => 'required'
    ];

    public function getDirectionAttribute()
    {
        $direction = ($this->attributes['direction']==1) ? 'left' : 'right';
        return $direction;
    }

//    public function setDirectionAttribute()
//    {
//        $direction = ($this->attributes['direction']=='left') ? 1 : 0;
//        return $direction;
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function tasks()
    {
        return $this->belongsToMany(\App\Models\Task::class, 'task_tags', 'tag_id', 'task_id');
    }
//    public function tasks()
//    {
//        return $this->belongsToMany(\App\Models\Task::class, 'task_tags', 'tag_id', 'task_id');
//    }
}
