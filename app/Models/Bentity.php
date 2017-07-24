<?php
namespace App\Models;
use Eloquent as Model;
class Bentity extends Model
{
    //
    protected $table = "bentity";
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';
    public $fillable=[
        'id',
        'name',
        'type',
        'tasktypes_id',
        'context'
    ];
    public function tasktype()
    {
        return $this->belongsTo(\App\Models\Tasktype::class, 'tasktypes_id', 'id');
    }
 public function task(){
      return $this ->hasMany(\App\Models\Task::class,'tasktype_id','tasktypes_id');
 }

}
