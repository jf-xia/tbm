<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Taskgroupview
 * @package App\Models
 * @version November 14, 2016, 11:35 am CST
 */
class Taskgroupview extends Model
{
    use SoftDeletes;

    public $table = 'v_taskgroups';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'task_id',
        'user_id'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user_id', function(Builder $builder) {
            $user = \Auth::user();
            $builder->where('user_id', '=', $user->id);
//            if(!$user->isAdmin()){
//                $builder->where('user_id', '=', 0)->orWhere('user_id', '=', $user->id)->orWhere('user_id', '=', $user->leader);
//            }
        });
    }

    
}
