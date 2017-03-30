<?php

namespace App\Repositories;

use App\Models\Taskcomment;
use App\Repositories\BaseRepository;

class TaskcommentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'task_id',
        'grade',
        'comment'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Taskcomment::class;
    }
}
