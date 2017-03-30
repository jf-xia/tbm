<?php

namespace App\Http\Controllers;

use App\DataTables\TaskstatusDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTaskstatusRequest;
use App\Http\Requests\UpdateTaskstatusRequest;
use App\Repositories\TaskstatusRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class TaskstatusController extends AppBaseController
{
    /** @var  TaskstatusRepository */
    private $taskstatusRepository;

    public function __construct(TaskstatusRepository $taskstatusRepo)
    {
        $this->taskstatusRepository = $taskstatusRepo;
    }

    /**
     * Display a listing of the Taskstatus.
     *
     * @param TaskstatusDataTable $taskstatusDataTable
     * @return Response
     */
    public function index(TaskstatusDataTable $taskstatusDataTable)
    {
        return $taskstatusDataTable->render('taskstatuses.index');
    }

    /**
     * Show the form for creating a new Taskstatus.
     *
     * @return Response
     */
    public function create()
    {
        return view('taskstatuses.create');
    }

    /**
     * Store a newly created Taskstatus in storage.
     *
     * @param CreateTaskstatusRequest $request
     *
     * @return Response
     */
    public function store(CreateTaskstatusRequest $request)
    {
        $input = $request->all();
        $input['user_id']=\Auth::id();

        $taskstatus = $this->taskstatusRepository->create($input);

        Flash::success('Taskstatus saved successfully.');

        return redirect(route('taskstatuses.index'));
    }

    /**
     * Display the specified Taskstatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $taskstatus = $this->taskstatusRepository->findWithoutFail($id);

        if (empty($taskstatus)) {
            Flash::error('Taskstatus not found');

            return redirect(route('taskstatuses.index'));
        }

        return view('taskstatuses.show')->with('taskstatus', $taskstatus);
    }

    /**
     * Show the form for editing the specified Taskstatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $taskstatus = $this->taskstatusRepository->findWithoutFail($id);

        if (empty($taskstatus)) {
            Flash::error('Taskstatus not found');

            return redirect(route('taskstatuses.index'));
        }

        return view('taskstatuses.edit')->with('taskstatus', $taskstatus);
    }

    /**
     * Update the specified Taskstatus in storage.
     *
     * @param  int              $id
     * @param UpdateTaskstatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTaskstatusRequest $request)
    {
        $taskstatus = $this->taskstatusRepository->findWithoutFail($id);

        if (empty($taskstatus)) {
            Flash::error('Taskstatus not found');

            return redirect(route('taskstatuses.index'));
        }

        $taskstatus = $this->taskstatusRepository->update($request->all(), $id);

        Flash::success('Taskstatus updated successfully.');

        return redirect(route('taskstatuses.index'));
    }

    /**
     * Remove the specified Taskstatus from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $taskstatus = $this->taskstatusRepository->findWithoutFail($id);

        if (empty($taskstatus)) {
            Flash::error('Taskstatus not found');

            return redirect(route('taskstatuses.index'));
        }

        $this->taskstatusRepository->delete($id);

        Flash::success('Taskstatus deleted successfully.');

        return redirect(route('taskstatuses.index'));
    }
}
