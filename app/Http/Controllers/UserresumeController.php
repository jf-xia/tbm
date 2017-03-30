<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserresumeRequest;
use App\Http\Requests\UpdateUserresumeRequest;
use App\Repositories\UserresumeRepository;
use App\Repositories\TaskRepository;
use App\User;
use App\Models\Userresume;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use App\Repositories\UserRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class UserresumeController extends AppBaseController
{
    private $taskRepository;
    private $userRepository;
    private $userresumeRepository;

    public function __construct(TaskRepository $taskRepo,
                                UserresumeRepository $userresumeRepo,
                                UserRepository $userRepository)
    {
        $this->taskRepository = $taskRepo;
        $this->userRepository = $userRepository;
        $this->userresumeRepository = $userresumeRepo;
    }

//    public function index(){
//        $posts = $this->taskRepository->postTasks();
//        return view('blogs.index',compact('posts'));
//    }
//
//    public function post($id)
//    {
//        $post = $this->taskRepository->findWithoutFail($id);
//
//        if (empty($post) || $post->price==0) {
//            abort(404);
//        }
//
//        //todo price+1 when post has been read
//        if ($post->price>0){
//            $this->taskRepository->update(['price'=>($post->price+1)],$id);
//        }
//
//        $user = $this->userRepository->findWithoutFail($post->user_id);
//        $posts = $this->taskRepository->postTasks($post->user_id);
//
//        return view('blogs.post',compact('post','posts','user','id'));
//    }
//
//    public function userinfo($id)
//    {
//        $user = $this->userRepository->findWithoutFail($id);
//
//        if (empty($user)) {
//            abort(404);
//        }
//        $posts = $this->taskRepository->postTasks($id);
//        $userresumes = $this->userresumeRepository->findWhere(['user_id'=>$id])->toArray();
//        $userresumeid = array_column($userresumes,'id','keyname');
//        $userresume = array_column($userresumes,'content','keyname');
////        $userresume = Userresume::all()->where('user_id','=',$id)->getDictionary();
////        dd($userresume);
//
//        return view('blogs.resumes',compact('userresume','userresumeid','id','posts'));
//    }
//
//    public function update_info(Request $request)
//    {
//        $input = $request->all();
//        $userresume = $this->userresumeRepository->findWithoutFail($input['id']);
//        \Log::debug($input);
//        if(empty($userresume)){
//            $input['user_id'] = \Auth::id();
//            $userresume = $this->userresumeRepository->create($input);
//            return 1;
//        } elseif ($userresume->user_id<>\Auth::id()) {
//            return 0;
//        }
//
//        $userresume = $this->userresumeRepository->update($input, $input['id']);
//
//        return 1;
//    }
}
