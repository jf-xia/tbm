<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Taskstatus
 * @package App\Models
 * @version November 3, 2016, 12:50 pm CST
 */
class Taskstatus extends Model
{
    use SoftDeletes;

    public $table = 'taskstatuses';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'color',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'color' => 'string',
        'user_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

//    protected static function boot()
//    {
//        parent::boot();
//
//        static::addGlobalScope('user_id', function(Builder $builder) {
//            $user = \Auth::user();
//            if(!$user->isAdmin()){
//                $builder->where('user_id', '=', 0)->orWhere('user_id', '=', $user->id)->orWhere('user_id', '=', $user->leader);
//            }
//        });
//    }
    
}
