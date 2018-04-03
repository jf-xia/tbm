<?php

namespace App\Repositories;

use App\Models\Tasktype_eav_value;
use App\Repositories\BaseRepository;

class Tasktype_eav_valueRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'task_id',
        'task_type_eav_id',
        'task_value'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tasktype_eav_value::class;
    }

    public function eavValue($taskid){
        //Tasktype_eav_value::where('task_id','=',$taskid)->get(['task_value','task_type_eav_id'])->toArray()
        return array_column(\DB::select('select task_value,task_type_eav_id from tasktype_eav_values where task_id=:task_id and deleted_at is null',['task_id'=>$taskid]),'task_value','task_type_eav_id');
    }

    public function getEavValue($taskid,$attrid){
        //Tasktype_eav_value::where('task_id','=',$taskid)->get(['task_value','task_type_eav_id'])->toArray()
        return \DB::select('select task_value from tasktype_eav_values where task_id=:task_id and task_type_eav_id=:attrid and deleted_at is null',['task_id'=>$taskid,'attrid'=>$attrid]);
    }

    public function getEntityFromValue($task_value,$attrid){
        //Tasktype_eav_value::where('task_id','=',$taskid)->get(['task_value','task_type_eav_id'])->toArray()
        return \DB::select('select task_id from tasktype_eav_values where task_value=:task_value and task_type_eav_id=:attrid and deleted_at is null',['task_value'=>$task_value,'attrid'=>$attrid]);
    }
}
