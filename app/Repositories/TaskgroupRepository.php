<?php

namespace App\Repositories;

use App\Models\Taskgroup;
use App\Repositories\BaseRepository;

class TaskgroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'task_id',
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Taskgroup::class;
    }
}
