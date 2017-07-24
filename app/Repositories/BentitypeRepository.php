<?php
namespace App\Repositories;
use App\Models\Bentity_type;
use App\Repositories\BaseRepository;

class BentitypeRepository extends BaseRepository
//class BentitypeRepository extends BaseRepository
{
    protected $fieldSearchable = [
        "name",
        "context",
        "update_at",
        "created_at"
    ];
    public function model()
    {
        return Bentity_type::class;
    }
}