<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Bentity_type extends Model{
    protected $table="bentity_type";
//    const CREATED_AT = 'trim';
    const UPDATED_AT = 'update_at';
    public $fillable=[
        "id",
        "name",
        "context"
    ];

}