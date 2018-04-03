<?php

namespace App\Models;

use App\User;
use Eloquent as Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Task
 * @package App\Models
 * @version November 1, 2016, 11:12 am CST
 */
class Task extends Model
{
    use SoftDeletes;

    public $table = 'tasks';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'content',
        'hours',
        'price',
        'end_at',
        'assigned_to',
        'informed',
        'task_id',
        'user_id',
        'taskstatus_id',
        'tasktype_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'content' => 'string',
        'hours' => 'decimal',
        'price' => 'integer',
        'end_at' => 'datetime',
        'assigned_to' => 'integer',
        'informed' => 'string',
        'task_id' => 'integer',
        'user_id' => 'integer',
        'taskstatus_id' => 'integer',
        'tasktype_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'taskstatus_id' => 'required',
        'tasktype_id' => 'required',
        'end_at' => 'date_format:"Y-m-d H:i:s"',
    ];

//    public function getGradegoodAttribute()
//    {
//        $gradetype=$this->taskgroup()->where('grade','=',1)->where('task_id','=',$this->attributes['task_id'])->count();
//        return $gradetype;
//    }
//
//    public function getGradebadAttribute()
//    {
//        $gradetype=$this->where('grade','=',2)->where('task_id','=',$this->attributes['task_id'])->count();
//        return $gradetype;
//    }

//    public function getProjectNameAttribute()
//    {
//        $projectName='无项目';
//        if ($this->project) {
//            $projectName = '<a href="'.route('tasks.project', $this->project->id).'" target="_blank" >'.
//                $this->project->customer_name.' ('.$this->project->project_serial.')</a>';
//        }
//        return $projectName;
//    }
//
//    public function getProductNameAttribute()
//    {
//        $productName='无产品';
//        if ($this->product) {
//            $productName = '<a href="'.route('tasks.product', $this->product->id).'" target="_blank" >'.
//                $this->product->prod_name.$this->product->prod_version.' ('.$this->product->prod_sku.')</a>';
//        }
//        return $productName;
//    }

    public function getInformedlistAttribute()
    {//User::whereIn('id',$this->getInformedAttribute())->get()->toArray()
        if (!$this->getInformedAttribute()) {
            return [];
        }
        $informedlist=array_column(\DB::select('select id,name from users where id in ('.implode(',', $this->getInformedAttribute()).')'), 'name', 'id');
        return $informedlist;
    }

    public function getInformedEmailAttribute()
    {
        if (!$this->getInformedAttribute()) {
            return [];
        }
        $informedlist=array_column(\DB::select('select id,email from users where id in ('.implode(',', $this->getInformedAttribute()).')'), 'email', 'id');
        return $informedlist;
    }

    public function getTaskOwnersNameAttribute()
    {
        $informedlist=array_column(\DB::select('select id,name from users where id in (select user_id FROM tasks WHERE (task_id = '.$this->id.' or id ='.$this->id.') and deleted_at is null)'), 'name', 'id');
        return $informedlist;
    }

    public function getTaskOwnersEmailAttribute()
    {
        $informedlist=[];
        if ($this->task_id) {
            $informedlist=array_column(\DB::select('select id,email from users where id in (select user_id FROM tasks WHERE (task_id = \''.$this->task_id.'\' or id =\''.$this->task_id.'\') and deleted_at is null)'), 'email', 'id');
        }
        return $informedlist;
    }

    public function getFirstTaskAttribute()
    {
        $taskId = $this->task_id ? $this->task_id : $this->id;
        $firstTask = \DB::selectOne("SELECT * FROM tasks WHERE id = '" . $taskId ."' and deleted_at is null");
        return $firstTask;
    }

    public function getTaskIsAssignedAttribute()
    {
        $taskIsAssigned = 1;
        if ($this->task_id && !$this->tasktype->multi_assigned) {
//            $taskId = $this->task_id ? $this->task_id : 0;
            $taskIsAssigned=(\DB::selectOne('SELECT max(id) as maxtaskcreate FROM tasks WHERE task_id = '.$this->task_id.' and deleted_at is null')->maxtaskcreate)==$this->id;
        } elseif (!$this->task_id) {
            $taskIsAssigned=(\DB::selectOne('SELECT max(id) as maxtaskcreate FROM tasks WHERE task_id = '.$this->id.' and deleted_at is null')->maxtaskcreate) ? 0 : 1;
        }
        return $taskIsAssigned;
    }

    public function getInformedAttribute()
    {
        return array_column($this->taskgroup->toArray(), 'user_id', 'id');
    }

    public function getTasktypeNameAttribute()
    {
        return $this->tasktype ? $this->tasktype->name : '';
    }

    public function getTaskstatusNameAttribute()
    {
        return $this->taskstatus ? $this->taskstatus->name : '';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function taskgroup()
    {
        return $this->hasMany(\App\Models\Taskgroup::class, 'task_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function project()
    {
        return $this->belongsTo(\App\Models\Project::class, 'project_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    // public function product()
    // {
    //     return $this->belongsTo(\App\Models\ProductMain::class, 'product_id', 'id');
    // }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    public function assigned()
    {
        return $this->belongsTo(\App\User::class, 'assigned_to', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function taskstatus()
    {
        return $this->belongsTo(\App\Models\Taskstatus::class, 'taskstatus_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function tasktype()
    {
        return $this->belongsTo(\App\Models\Tasktype::class, 'tasktype_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(\App\Models\Tag::class, 'task_tags', 'task_id', 'tag_id');
    }

//    protected static function boot()
//    {
//        parent::boot();
//
//        static::addGlobalScope('user_id', function(Builder $builder) {
//                $builder->orderBy('created_at', 'desc');
//        });
//    }
}
