<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\DataTables\TasktypeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTasktypeRequest;
use App\Http\Requests\UpdateTasktypeRequest;
use App\Models\Tasktype_eav;
use App\Repositories\TaskRepository;
use App\Repositories\TasktypeRepository;
use App\Repositories\Tasktype_eavRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class TasktypeController extends AppBaseController
{
    /** @var  TasktypeRepository */
    private $taskRepository;
    private $tasktypeRepository;
    private $taskTypeEavRepo;

    public function __construct(TaskRepository $taskRepo,TasktypeRepository $tasktypeRepo,Tasktype_eavRepository $tasktype_eavRepository)
    {
        $this->taskRepository = $taskRepo;
        $this->tasktypeRepository = $tasktypeRepo;
        $this->taskTypeEavRepo = $tasktype_eavRepository;
    }

    /**
     * Display a listing of the Tasktype.
     *
     * @param TasktypeDataTable $tasktypeDataTable
     * @return Response
     */
    public function index(TasktypeDataTable $tasktypeDataTable)
    {
        return $tasktypeDataTable->render('tasktypes.index');
    }

    /**
     * @return \Illuminate\View\ajax
     */
    public function ajaxlist(Request $request)
    {
        $input = $request->all();
        $term='%'.$input['term'].'%';
        $userlist = \DB::select("select id,name as text from tasktypes where name LIKE :name and deleted_at is null LIMIT 20", ['name'=>$term]);
        return \Response::json($userlist);
    }

    /**
     * Show the form for creating a new Tasktype.
     *
     * @return Response
     */
    public function create()
    {
        $taskTypeList = $this->tasktypeRepository->getTaskTypeList();
        return view('tasktypes.create',compact('taskTypeList'));
    }

    /**
     * Store a newly created Tasktype in storage.
     *
     * @param CreateTasktypeRequest $request
     *
     * @return Response
     */
    public function store(CreateTasktypeRequest $request)
    {
        $input = $request->all();
        $input['user_id']=\Auth::id();

        if (isset($input['tasktype_id'])){
            $input['tasktype_id']=implode('|',$input['tasktype_id']);
        } else {
            $input['tasktype_id']='';
        }

        $tasktype = $this->tasktypeRepository->create($input);

        Flash::success('Tasktype saved successfully.');

        return redirect(route('tasktypes.edit',$tasktype->id));
    }

    /**
     * Display the specified Tasktype.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tasktype = $this->tasktypeRepository->findWithoutFail($id);

        if (empty($tasktype)) {
            Flash::error('Tasktype not found');

            return redirect(route('tasktypes.index'));
        }

        return view('tasktypes.show')->with('tasktype', $tasktype);
    }

    /**
     * Show the form for editing the specified Tasktype.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tasktype = $this->tasktypeRepository->findWithoutFail($id);
        $tasktypeeav = $this->taskTypeEavRepo->taskTypeEav($id);
        $taskTypeList = $this->tasktypeRepository->getTaskTypeList();

        if (empty($tasktype)) {
            Flash::error('Tasktype not found');

            return redirect(route('tasktypes.index'));
        }

        return view('tasktypes.edit',compact('tasktype','tasktypeeav','taskTypeList'));
    }

    /**
     * Update the specified Tasktype in storage.
     *
     * @param  int              $id
     * @param UpdateTasktypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTasktypeRequest $request)
    {
        $tasktype = $this->tasktypeRepository->findWithoutFail($id);

        if (empty($tasktype)) {
            Flash::error('Tasktype not found');

            return redirect(route('tasktypes.index'));
        }
        $input = $request->all();

        if (isset($input['tasktype_id'])){
            $input['tasktype_id']=implode('|',$input['tasktype_id']);
        } else {
            $input['tasktype_id']='';
        }

        $tasktype = $this->tasktypeRepository->update($input, $id);

        Flash::success('Tasktype updated successfully.');

        return redirect(route('tasktypes.index'));
    }

    /**
     * Remove the specified Tasktype from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $tasktype = $this->tasktypeRepository->findWithoutFail($id);

        if (empty($tasktype)) {
            Flash::error('Tasktype not found');

            return redirect(route('tasktypes.index'));
        }

        $taskDs = $this->taskRepository->deleteWhere(['tasktype_id'=>$id]);
        $this->tasktypeRepository->delete($id);

        Flash::success('Tasktype deleted successfully.');

        return redirect(route('tasktypes.index'));
    }
}
