<?php

namespace App\Http\Controllers;

use App\DataTables\TaskcommentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTaskcommentRequest;
use App\Http\Requests\UpdateTaskcommentRequest;
use App\Repositories\TaskcommentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class TaskcommentController extends AppBaseController
{
    /** @var  TaskcommentRepository */
    private $taskcommentRepository;

    public function __construct(TaskcommentRepository $taskcommentRepo)
    {
        $this->taskcommentRepository = $taskcommentRepo;
    }

    public function create(CreateTaskcommentRequest $request)
    {
        $input = $request->all();
        $taskcomment = $this->taskcommentRepository->create(['task_id'=>$input['sectionId'],'comment'=>$input['comment'],'user_id'=>\Auth::id()]);
        $comment = [];
        $comment['id'] = $taskcomment->id;
        $comment['sectionId'] = $taskcomment->task_id;
        $comment['authorAvatarUrl'] = '/images/blue_logo_150x150.jpg';
        $comment['authorName'] = $taskcomment->user->name;
        $comment['authorId'] = $taskcomment->user_id;
        $comment['authorUrl'] = route('index.user',$taskcomment->user_id);
        $comment['comment'] = $taskcomment->comment;
        $comment['created_at'] = $taskcomment->created_at->toDateString();

        return ($comment);
    }

    public function show($id)
    {
        $comments = [];
        $taskcomments = $this->taskcommentRepository->findWhere(['task_id'=>$id])->sortByDesc('created_at');
        foreach($taskcomments as $taskcomment){
            $comment = [];
            $comment['id'] = $taskcomment->id;
            $comment['authorAvatarUrl'] = '/images/blue_logo_150x150.jpg';
            $comment['authorName'] = $taskcomment->user->name;
            $comment['authorId'] = $taskcomment->user_id;
            $comment['authorUrl'] = route('index.user',$taskcomment->user_id);
            $comment['comment'] = $taskcomment->comment;
            $comment['created_at'] = $taskcomment->created_at->toDateString();
            $comments[] = $comment;
        }
        return ($comments);
    }

    public function delete($id)
    {
        $taskcomment = $this->taskcommentRepository->findWithoutFail($id);

        if (empty($taskcomment)) {
            return 0;
        }

        $this->taskcommentRepository->delete($id);
        return 1;
    }

//    public function index(TaskcommentDataTable $taskcommentDataTable)
//    {
//        return $taskcommentDataTable->render('taskcomments.index');
//    }
//
//    /**
//     * Show the form for creating a new Taskcomment.
//     *
//     * @return Response
//     */
//    public function create()
//    {
//        return view('taskcomments.create');
//    }
//
//    /**
//     * Store a newly created Taskcomment in storage.
//     *
//     * @param CreateTaskcommentRequest $request
//     *
//     * @return Response
//     */
//    public function store(CreateTaskcommentRequest $request)
//    {
//        $input = $request->all();
//
//        $taskcomment = $this->taskcommentRepository->create($input);
//
//        Flash::success('Taskcomment saved successfully.');
//
//        return redirect(route('taskcomments.index'));
//    }
//
//    /**
//     * Display the specified Taskcomment.
//     *
//     * @param  int $id
//     *
//     * @return Response
//     */
//    public function show($id)
//    {
//        $taskcomment = $this->taskcommentRepository->findWithoutFail($id);
//
//        if (empty($taskcomment)) {
//            Flash::error('Taskcomment not found');
//
//            return redirect(route('taskcomments.index'));
//        }
//
//        return view('taskcomments.show')->with('taskcomment', $taskcomment);
//    }
//
//    /**
//     * Show the form for editing the specified Taskcomment.
//     *
//     * @param  int $id
//     *
//     * @return Response
//     */
//    public function edit($id)
//    {
//        $taskcomment = $this->taskcommentRepository->findWithoutFail($id);
//
//        if (empty($taskcomment)) {
//            Flash::error('Taskcomment not found');
//
//            return redirect(route('taskcomments.index'));
//        }
//
//        return view('taskcomments.edit')->with('taskcomment', $taskcomment);
//    }
//
//    /**
//     * Update the specified Taskcomment in storage.
//     *
//     * @param  int              $id
//     * @param UpdateTaskcommentRequest $request
//     *
//     * @return Response
//     */
//    public function update($id, UpdateTaskcommentRequest $request)
//    {
//        $taskcomment = $this->taskcommentRepository->findWithoutFail($id);
//
//        if (empty($taskcomment)) {
//            Flash::error('Taskcomment not found');
//
//            return redirect(route('taskcomments.index'));
//        }
//
//        $taskcomment = $this->taskcommentRepository->update($request->all(), $id);
//
//        Flash::success('Taskcomment updated successfully.');
//
//        return redirect(route('taskcomments.index'));
//    }
//
//    /**
//     * Remove the specified Taskcomment from storage.
//     *
//     * @param  int $id
//     *
//     * @return Response
//     */
//    public function destroy($id)
//    {
//        $taskcomment = $this->taskcommentRepository->findWithoutFail($id);
//
//        if (empty($taskcomment)) {
//            Flash::error('Taskcomment not found');
//
//            return redirect(route('taskcomments.index'));
//        }
//
//        $this->taskcommentRepository->delete($id);
//
//        Flash::success('Taskcomment deleted successfully.');
//
//        return redirect(route('taskcomments.index'));
//    }
}
