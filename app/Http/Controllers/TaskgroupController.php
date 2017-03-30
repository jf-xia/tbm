<?php

namespace App\Http\Controllers;

use App\DataTables\TaskgroupDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTaskgroupRequest;
use App\Http\Requests\UpdateTaskgroupRequest;
use App\Repositories\TaskgroupRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class TaskgroupController extends AppBaseController
{
    /** @var  TaskgroupRepository */
    private $taskgroupRepository;

    public function __construct(TaskgroupRepository $taskgroupRepo)
    {
        $this->taskgroupRepository = $taskgroupRepo;
    }

    /**
     * Display a listing of the Taskgroup.
     *
     * @param TaskgroupDataTable $taskgroupDataTable
     * @return Response
     */
    public function index(TaskgroupDataTable $taskgroupDataTable)
    {
        return $taskgroupDataTable->render('taskgroups.index');
    }

    public function type(TaskgroupDataTable $taskgroupDataTable,$type=0)
    {
        $taskgroupDataTable->setShowType($type);
        return $taskgroupDataTable->render('taskgroups.index');
    }

    /**
     * Show the form for creating a new Taskgroup.
     *
     * @return Response
     */
    public function create()
    {
        return view('taskgroups.create');
    }

    /**
     * Store a newly created Taskgroup in storage.
     *
     * @param CreateTaskgroupRequest $request
     *
     * @return Response
     */
    public function store(CreateTaskgroupRequest $request)
    {
        $input = $request->all();
        $input['user_id']=\Auth::id();

        $taskgroup = $this->taskgroupRepository->create($input);

        Flash::success('Taskgroup saved successfully.');

        return redirect(route('taskgroups.index'));
    }

    /**
     * Display the specified Taskgroup.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $taskgroup = $this->taskgroupRepository->findWithoutFail($id);

        if (empty($taskgroup)) {
            Flash::error('Taskgroup not found');

            return redirect(route('taskgroups.index'));
        }

        return view('taskgroups.show')->with('taskgroup', $taskgroup);
    }

    /**
     * Show the form for editing the specified Taskgroup.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $taskgroup = $this->taskgroupRepository->findWithoutFail($id);

        if (empty($taskgroup)) {
            Flash::error('Taskgroup not found');

            return redirect(route('taskgroups.index'));
        }

        return view('taskgroups.edit')->with('taskgroup', $taskgroup);
    }

    /**
     * Update the specified Taskgroup in storage.
     *
     * @param  int              $id
     * @param UpdateTaskgroupRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTaskgroupRequest $request)
    {
        $taskgroup = $this->taskgroupRepository->findWithoutFail($id);

        if (empty($taskgroup)) {
            Flash::error('Taskgroup not found');

            return redirect(route('taskgroups.index'));
        }

        $taskgroup = $this->taskgroupRepository->update($request->all(), $id);

        Flash::success('Taskgroup updated successfully.');

        return redirect(route('taskgroups.index'));
    }

    public function updateajax($id, $type, $comment)
    {
        $groupComment = $this->taskgroupRepository->findWithoutFail($id);

        if (empty($groupComment)) {
            return '当前任务不存在，评价失败！';
        }
        $input['grade']=$type;
        $input['comment']=$comment;
        $groupComment = $this->taskgroupRepository->update($input, $id);

        try{
            $informed = \Mail::send('emails.task_comment',['groupComment'=>$groupComment],function($message) use ($groupComment) {
//                $message->from(env('MAIL_USERNAME').env('MAIL_COM'),env('MAIL_USERNAME'));
                $message->to($groupComment->task->user->email);
                $message->bcc('Task.system@gtafe.com');
                $message->subject($groupComment->user->name.'评价了你的任务'.'['.$groupComment->task->title.']');
//                foreach ($groupComment->task->informed_email as $to) {
//                    $message->to($to);
//                }
//                foreach ($groupComment->task->task_owners_email as $cc) {
//                    $message->cc($cc);
//                }
            });
        } catch (Exception $e) {
//            throw $e;
            \Log::warning($e);
        }

        return '任务评价完成！';
    }

    /**
     * Remove the specified Taskgroup from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $taskgroup = $this->taskgroupRepository->findWithoutFail($id);

        if (empty($taskgroup)) {
            Flash::error('Taskgroup not found');

            return redirect(route('taskgroups.index'));
        }

        $this->taskgroupRepository->delete($id);

        Flash::success('Taskgroup deleted successfully.');

        return redirect(route('taskgroups.index'));
    }
}
