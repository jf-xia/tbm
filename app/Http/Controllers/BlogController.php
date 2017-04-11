<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Task_tag;
use App\Models\Userresume;
use App\Repositories\UserresumeRepository;
use App\Repositories\TagRepository;
use App\Repositories\TaskRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Response;

class BlogController extends AppBaseController
{
    private $taskRepository;
    private $tagRepository;
    private $userRepository;
    private $userresumeRepository;

    public function __construct(TaskRepository $taskRepo, TagRepository $tagRepo, UserresumeRepository $userresumeRepo, UserRepository $userRepo)
    {
        $this->taskRepository = $taskRepo;
        $this->tagRepository = $tagRepo;
        $this->userRepository = $userRepo;
        $this->userresumeRepository = $userresumeRepo;
    }

    public function tagBlock($tagid=0)
    {
//        $cache = \Cache::store('file');
//        $tags = cache('tags');
//        if (!$tags) {
//            $tags = \DB::select('SELECT tags.`topic`,tags.id,COUNT(task_tags.id) as tagcount FROM tags INNER JOIN task_tags ON task_tags.tag_id = tags.id GROUP BY task_tags.tag_id ORDER BY tagcount DESC Limit 16');
//            cache(['tags'=>$tags],60);
//        }
        $tags = $this->tagRepository->paginate(15)->sortBy('parentid');
        $tagHtml = '<div class="tagcloud"><ul>';
        foreach($tags as $tag){
            if($tagid==$tag->id){
                $tagHtml .= '<li><a class="active" href="#">'.$tag->topic.'</a></li>';//<span>'.$tag->tagcount.'</span>
            } else {
                $tagHtml .= '<li><a href="'.route('index.tag',['price',$tag->id]).'" title="'.$tag->topic.'" >'.$tag->topic.'</a></li>';//<span>'.$tag->tagcount.'</span>
            }
        }
        $tagHtml .= '<li><a href="'.route('index.tag',['price','o']).'" title="Null" >Null</a></li>';
        $tagHtml .= '</ul></div>';
        return $tagHtml;
    }

    public function index($sort='updated_at',$tagid=0,$search=0){
        $posts = $this->taskRepository->postTasks(0,$sort,$tagid,$search);
        $tagHtml = $this->tagBlock($tagid);
        $tags = $this->tagRepository->all()->sortBy('sort')->toArray();
        if ($tagid){
            $tag = $this->tagRepository->findWithoutFail($tagid);
            if (!empty($tag)){
                array_unshift($tags,["id"=>$tag->id, "isroot"=>true, "topic"=>$tag->topic]);
            }
        }else{
            array_unshift($tags,["id"=>"0", "isroot"=>true, "topic"=>trans('view.LearnShare')]);
        }
        $tags = json_encode($tags);
        $posts = $posts->paginate(12);
        return view('blogs.index',compact('posts','tagHtml','tags'));
    }

    public function post($id)
    {
        $post = $this->taskRepository->findWithoutFail($id);

        if (empty($post) || $post->price==0) {
            abort(404);
        }

//        $cache = \Cache::store('file');
//        $cache->put('post',[$id.'_'.\Auth::id()=>1]+$cache->get('post'),30);
//        $test = !array_key_exists($id.'_'.\Auth::id(),$cache->get('post'));
        //todo price+1 when post has been read
        if ($post->price>0 && !session('post'.$id)){
            $post->timestamps = false;
            $post->update(['price'=>($post->price+1)]);
            session(['post'.$id=>$id]);
        }
        $userresumes = $this->userresumeRepository->findWhere(['user_id'=>$post->user_id])->toArray();
        $userresumeid = array_column($userresumes,'id','keyname');
        $userresume = array_column($userresumes,'content','keyname');

//        $user = $this->userRepository->findWithoutFail($post->user_id);
        $posts = $this->taskRepository->postTasks($post->user_id);
        $posts = $posts->paginate(15);
        $tagHtml = $this->tagBlock();
        $user = $post->user;

        return view('blogs.post',compact('userresume','userresumeid','post','posts','user','id','tagHtml'));
    }

    public function userinfo($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            abort(404);
        }
        $userresumes = $this->userresumeRepository->findWhere(['user_id'=>$id])->toArray();
        $userresumeid = array_column($userresumes,'id','keyname');
        $userresume = array_column($userresumes,'content','keyname');

        $posts = $this->taskRepository->postTasks($id);
        $posts = $posts->paginate(15);
//        $userresume = Userresume::all()->where('user_id','=',$id)->getDictionary();

        return view('blogs.resumes',compact('userresume','userresumeid','user','id','posts'));
    }

    public function habitsAjax($user_id)
    {
        $userhabits = \DB::select('select * from userresumes where deleted_at IS NULL AND user_id=:user_id and keyname like \'%0:00\'',['user_id'=>$user_id]);
            //Userresume::all()->where('user_id','=',$user_id)->where('keyname','like','%0:00');
        return \Response::json($userhabits);
    }

    public function updateTagAjax(Request $request) {
        if (\Auth::id()<>9) return 0;

        $input = $request->all();
        $data = isset($input['jsondata']['data']) ? $input['jsondata']['data'] : [];

        foreach ($data as $key=>$row){
//            \Log::alert($key,$row);
            if (isset($row['topic']) && isset($row['id']) && !isset($row['isroot'])) {
                $row['sort'] = $key;
                $direction = isset($row['direction']) ? $row['direction'] : 'right';
                $row['direction'] = ($direction =='left') ? 1 : 0;

                $tag = $this->tagRepository->findWithoutFail($row['id']);
                if (empty($tag)){
                    $tag = $this->tagRepository->create($row);
                } elseif($tag->topic<>$row['topic']||$tag->direction<>$direction||$tag->parentid<>$row['parentid']) {//$tag->sort<>$row['sort']||
                    $tag = $this->tagRepository->update($row,$row['id']);
//                    \Log::debug('update-topic'.($tag->topic<>$row['topic']).'sort-'.($tag->sort<>$row['sort']).'direction-'.($tag->direction<>$row['direction']).'parentid-'.($tag->parentid<>$row['parentid']).$tag->direction.$row['direction']);
                }
            }
        }

        return 1;
    }

    public function createTagAjax($id,$name)
    {
        $post = $this->taskRepository->findWithoutFail($id);
        if ($post){
            if(is_numeric($name)){
                $tag = Tag::find($name);
                if ($tag && !in_array($tag->id,array_column($post->tags->toArray(),'id'))){
//                $post->tags->sync();
                    Task_tag::create(['task_id'=>$id,'tag_id'=>$name,'user_id'=>\Auth::id()]);
                    return \Response::json(['id'=>$tag->id,'topic'=>$tag->topic]);
                }
            } else {
                if (!Tag::where('topic','=',$name)->count()){
                    $tag = Tag::create(['topic'=>$name]);
                    Task_tag::create(['task_id'=>$id,'tag_id'=>$tag->id,'user_id'=>\Auth::id()]);
                    return \Response::json(['id'=>$tag->id,'topic'=>$tag->topic]);
                }
            }
        }
        return 0;
    }

    public function removeTagAjax($id,$name)
    {
        $task_tags = Task_tag::where('task_id','=',$id)->where('tag_id','=',$name)->get();
        if (empty($task_tags)){
            return 0;
        }

        foreach ($task_tags as $task_tag) {
            $task_tag->delete();
        }

        return $name;
    }

    public function tagAjax(Request $request)
    {
        $input = $request->all();
        $tags = $this->tagRepository->findWhere([['topic','like','%'.$input['term'].'%']],['id','topic as text'])->toJson();
        return ($tags);
    }

    public function update_info(Request $request)
    {
        $input = $request->all();
        $id = isset($input['id']) ? $input['id'] : 0 ;
        $userresume = $this->userresumeRepository->findWithoutFail($id);
//        \Log::debug($input);
        $input['user_id'] = \Auth::id();
        if(empty($userresume)){
            $userresume = $this->userresumeRepository->create($input);
            return $userresume->id;
        } elseif ($userresume->user_id<>\Auth::id()) {
            return 0;
        }
        $userresume->delete($input['id']);
        if ($input['content']<>''){
            $userresume = $this->userresumeRepository->create($input);
        }
//        $userresume = $this->userresumeRepository->update($input, $id);

        return $userresume->id;
    }
}
