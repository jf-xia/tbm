<?php

namespace App\Repositories;

use App\Models\Userresume;
use App\Repositories\BaseRepository;

class UserresumeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'keyname',
        'content',
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Userresume::class;
    }
}
