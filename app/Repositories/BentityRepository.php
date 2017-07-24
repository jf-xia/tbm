<?php

namespace App\Repositories;
use App\Repositories\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Models\Bentity;

class BentityRepository extends BaseRepository implements CacheableInterface
{
    protected $cacheMinutes = 90;



    use CacheableRepository;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'context',
        'tasktypes_id',
        'create_at',
        'update_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Bentity::class;
    }


 //取得业务库名称
    public function getBentityList(){
        $getBentityList=array_column($this->all()->sortBy('id')->toArray(),'name','id');
        return $getBentityList;
    }


}
