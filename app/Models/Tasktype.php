<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Tasktype
 * @package App\Models
 * @version November 4, 2016, 1:48 pm CST
 */
class Tasktype extends Model
{
    use SoftDeletes;

    public $table = 'tasktypes';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'color',
        'assigned_to',
        'multi_assigned',
        'project_required',
        'product_required',
        'comment_required',
        'user_id',
        'tasktype_id',
        'bentity_id'  //huayan
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'color' => 'string',
        'assigned_to' => 'integer',
        'multi_assigned' => 'integer',
        'project_required' => 'integer',
        'product_required' => 'integer',
        'comment_required' => 'integer',
        'user_id' => 'integer',
        'tasktype_id'=> 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function getTasktypeSelectAttribute()
    {
//        $taskTypeSelect=[];//$this->find($this->attributes['tasktype_id'])->name;
//        foreach(explode('|',$this->attributes['tasktype_id']) as $ttid){
//            $taskTypeSelect[$ttid]=\DB::select("select name from tasktypes where deleted_at is null and id = :id", ['id'=>$ttid])[0]->name;
//            //$ttid;//$this->find($ttid)->name;
//        }
        //$taskTypeSelect=array_column(Tasktype::whereIn('id',explode('|',$this->attributes['tasktype_id']))->get()->toArray(),'name','id');
        $taskTypeSelect=[];
//        dd($this->getTasktypeIdsAttribute());
        if ($this->getTasktypeIdsAttribute()[0]){
//            \DB::setFetchMode(\PDO::FETCH_ASSOC);
            $typeQy = \DB::select("select id, name from tasktypes where deleted_at is null and id in (".implode(',',$this->getTasktypeIdsAttribute()).")");
            $taskTypeSelect = array_column($typeQy,'name','id');
//            dd($typeQy,$taskTypeSelect);
        }
        return $taskTypeSelect;
    }

    public function getTasktypeIdsAttribute(){
        return explode('|',$this->attributes['tasktype_id']);
    }

    public function getTasktypeNameAttribute()
    {
        $taskTypeName=implode(', ',$this->getTasktypeSelectAttribute());
        return $taskTypeName;
    }

    public function getAssignedtoNameAttribute()
    {
        $assignedtoName=$this->assignedto ? $this->assignedto->name : '';
        return $assignedtoName;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function assignedto()
    {
        return $this->belongsTo(\App\User::class, 'assigned_to', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

//        static::updating(function ($model) {
//            return false;
//        });
//        static::addGlobalScope('user_id', function(Builder $builder) {
//            $user = \Auth::user();
//            if(!$user->isAdmin()){
//                $builder->where('user_id', '=', 0)->orWhere('user_id', '=', $user->id)->orWhere('user_id', '=', $user->leader);
//            }
//        });
    }

}
