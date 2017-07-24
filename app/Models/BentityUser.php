<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BentityUser extends Model{
    protected $table="bentity_user";
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';
    public $fillable=[
        "id",
        "user_id",
        "tasktypes_id"
    ];

    public function tasktype()
    {
        return $this->belongsTo(\App\Models\Tasktype::class, 'tasktypes_id', 'id');
    }

    public function user(){
//        $user = \Auth::user();
        return $this->belongsTo(\Auth::user(),'user_id','id');
    }
}