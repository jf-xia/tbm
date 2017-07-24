<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\Task_tag;
use App\Repositories\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

class TaskRepository extends BaseRepository //implements CacheableInterface
{
//    protected $cacheMinutes = 90;
//
//    protected $cacheOnly = ['find','paginate'];
////    //or   all, paginate, find, findByField, findWhere, getByCriteria
////    protected $cacheExcept = ['find'];
//
//    use CacheableRepository;

    /**
     * @var array //huayan
     */
    protected $fieldSearchable = [
        'title'=>'like',
//        'content',
//        'hours',
//        'end_at',
//        'informed',
//        'project_id',
//        'user_id',
//        'taskstatus_id',
//        'tasktype_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Task::class;
    }

    public function uncertainTasks()
    {
        return Task::whereNull('end_at');
    }

    public function postTasks($userId=0,$sort='price',$tag=0,$search=0)
    {
        $tasks = Task::where('price','<>',0);
        if ($search){
            $tasks = $tasks->where('title','like','%'.$search.'%');
        }
        if ($userId){
            $tasks = $tasks->where('user_id','=',$userId);
        }
        if ($tag){
            if($tag=='o'){
                $postIds = Task_tag::all()->toArray();
                $tasks = $tasks->whereNotIn('id',array_column($postIds,'task_id'));
            }else{
                $postIds = Task_tag::where('tag_id','=',$tag)->get()->toArray();
                $tasks = $tasks->whereIn('id',array_column($postIds,'task_id'));
            }
        }
        if ($sort=='created_at'||$sort=='updated_at'||$sort=='price') {
            $tasks = $tasks->orderBy($sort,'desc');
        }

        return $tasks;
    }



    //原数据
    public function subTaskInfo($taskId)
    {
        $subTask=null;
        if ($taskId){
            $subTask = $this->findWhere(['task_id'=>$taskId])->sortByDesc('created_at');
        }
        if ($this->findWithoutFail($taskId)){
            $task = $this->findWithoutFail($taskId);
            $subTask[]=$task;
        }
        return $subTask;
    }


    //获取业务库任务类型名称
//    public  function getBenTaskList(){
//        $getBenTaskList=array_column($this->all()->sortBy('id')->toArray(),'name','id');
//        return $getBenTaskList;
//    }

}
