<?php

namespace App\Models;

use Eloquent as Model;
//use FontLib\Table\Type\name;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Task
 * @package App\Models
 * @version November 1, 2016, 11:12 am CST
 */
class UploadLog extends Model
{

    public $table = 'uploads';
    
    public $fillable = [
        'user_id',
        'tasktype_id',
        'file_name',
        'upload_ids',
        'import_ids',
        'error_ids'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'tasktype_id' => 'integer',
        'file_name' => 'string',
        'upload_ids' => 'string',
        'import_ids' => 'string',
        'error_ids' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'tasktype_id' => 'required',
        'file_name' => 'required'
    ];

//    public function getXxxAttribute()
//    {
//        return 111;
//    }

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }
//
//    public function tags()
//    {
//        return $this->belongsToMany(\App\Models\Tag::class, 'task_tags', 'task_id', 'tag_id');
//    }

//    protected static function boot()
//    {
//        parent::boot();
//
//        static::addGlobalScope('user_id', function(Builder $builder) {
//                $builder->orderBy('created_at', 'desc');
//        });
//    }
}
