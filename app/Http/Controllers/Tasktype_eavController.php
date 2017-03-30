<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateTasktype_eavRequest;
use App\Http\Requests\UpdateTasktype_eavRequest;
use App\DataTables\Tasktype_eavDataTable;
use App\Repositories\Tasktype_eavRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class Tasktype_eavController extends AppBaseController
{
    /** @var  Tasktype_eavRepository */
    private $tasktypeEavRepository;

    public function __construct(Tasktype_eavRepository $tasktypeEavRepo)
    {
        $this->tasktypeEavRepository = $tasktypeEavRepo;
    }

    /**
     * Display a listing of the Tasktype_eav.
     *
     * @param Tasktype_eavDataTable $tasktypeEavDataTable
     * @return Response
     */
    public function index(Tasktype_eavDataTable $tasktypeEavDataTable)
    {
        return $tasktypeEavDataTable->render('tasktype_eavs.index');
    }

    /**
     * Show the form for creating a new Tasktype_eav.
     *
     * @return Response
     */
    public function create($tasktype_id = null)
    {
        return view('tasktype_eavs.create')->with('tasktype_id',$tasktype_id);
    }

    /**
     * Store a newly created Tasktype_eav in storage.
     *
     * @param CreateTasktype_eavRequest $request
     *
     * @return Response
     */
    public function store(CreateTasktype_eavRequest $request)
    {
        $input = $request->all();
        if (isset($input['option'])) {
            $input['option']=implode('|',$input['option']);
        } else {
            $input['option']='';
        }
        $input['user_id']=\Auth::id();
        $input['code']=$input['frontend_input'].$input['tasktype_id'].date("ymdhis");

        $tasktypeEav = $this->tasktypeEavRepository->create($input);

        Flash::success('Tasktype Eav saved successfully.');

        return redirect(route('tasktypes.edit',['id'=>$input['tasktype_id']]));
    }

    /**
     * Display the specified Tasktype_eav.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tasktypeEav = $this->tasktypeEavRepository->findWithoutFail($id);

        if (empty($tasktypeEav)) {
            Flash::error('Tasktype Eav not found');

            return redirect(route('tasktypeEavs.index'));
        }

        return view('tasktype_eavs.show')->with('tasktypeEav', $tasktypeEav);
    }

    /**
     * Show the form for editing the specified Tasktype_eav.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tasktypeEav = $this->tasktypeEavRepository->findWithoutFail($id);

        if (empty($tasktypeEav)) {
            Flash::error('Tasktype Eav not found');

            return redirect(route('tasktypeEavs.index'));
        }

        return view('tasktype_eavs.edit')->with('tasktypeEav', $tasktypeEav);
    }

    /**
     * Update the specified Tasktype_eav in storage.
     *
     * @param  int              $id
     * @param UpdateTasktype_eavRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTasktype_eavRequest $request)
    {
        $tasktypeEav = $this->tasktypeEavRepository->findWithoutFail($id);
        $input = $request->all();
        if (isset($input['option'])) {
            $input['option']=implode('|',$input['option']);
        }else{
            $input['option']='';
        }

        if (empty($tasktypeEav)) {
            Flash::error('Tasktype Eav not found');

            return redirect(route('tasktypeEavs.index'));
        }

        $tasktypeEav = $this->tasktypeEavRepository->update($input, $id);

        Flash::success('Tasktype Eav updated successfully.');

        return redirect(route('tasktypes.edit',['id'=>$tasktypeEav->tasktype_id]));
    }

    /**
     * Remove the specified Tasktype_eav from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $tasktypeEav = $this->tasktypeEavRepository->findWithoutFail($id);
        $tasktype_id = $tasktypeEav->tasktype_id;
        if (empty($tasktypeEav)) {
            Flash::error('Tasktype Eav not found');

            return redirect(route('tasktypeEavs.index'));
        }

        $this->tasktypeEavRepository->delete($id);

        Flash::success('Tasktype Eav deleted successfully.');

        return redirect(route('tasktypes.edit',['id'=>$tasktype_id]));
    }
}
