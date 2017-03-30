<?php

namespace App\Repositories;

use App\Models\Tasktype_eav;
use App\Repositories\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

class Tasktype_eavRepository extends BaseRepository implements CacheableInterface
{
    protected $cacheMinutes = 90;

//    protected $cacheOnly = ['all','paginate'];
//    //or   all, paginate, find, findByField, findWhere, getByCriteria
//    protected $cacheExcept = ['find'];

    use CacheableRepository;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tasktype_id',
        'code',
        'frontend_label',
        'frontend_input',
        'frontend_size',
        'is_required',
        'is_unique',
        'option',
        'user_id',
        'note'
    ];

    public function taskTypeEav($taskTypeId){
        return $this->findWhere(['tasktype_id'=>$taskTypeId])->sortBy('orderby');
//        return \DB::select('select * from tasktype_eavs where tasktype_id=:taskTypeId and deleted_at is null order by orderby',['taskTypeId'=>$taskTypeId]);
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tasktype_eav::class;
    }
}
