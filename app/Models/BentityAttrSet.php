<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BentityAttrSet extends Model{
    protected $table="bentity_attr_set";
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';
    public $fillable=[
        "id",
        "bentity_id",
        "tasktypes_id"
    ];

//多表连接
    public function bentity()
    {
        return $this->belongsTo(\App\Models\Bentity::class, 'bentity_id', 'id');
    }
//多表连接
    public function tasktype()
    {
        return $this->belongsTo(\App\Models\Tasktype::class, 'tasktypes_id', 'id');
    }

}