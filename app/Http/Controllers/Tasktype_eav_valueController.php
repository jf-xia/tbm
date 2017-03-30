<?php

namespace App\Http\Controllers;

use App\DataTables\Tasktype_eav_valueDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTasktype_eav_valueRequest;
use App\Http\Requests\UpdateTasktype_eav_valueRequest;
use App\Repositories\Tasktype_eav_valueRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class Tasktype_eav_valueController extends AppBaseController
{
    /** @var  Tasktype_eav_valueRepository */
    private $tasktypeEavValueRepository;

    public function __construct(Tasktype_eav_valueRepository $tasktypeEavValueRepo)
    {
        $this->tasktypeEavValueRepository = $tasktypeEavValueRepo;
    }

    /**
     * Display a listing of the Tasktype_eav_value.
     *
     * @param Tasktype_eav_valueDataTable $tasktypeEavValueDataTable
     * @return Response
     */
//    public function index(Tasktype_eav_valueDataTable $tasktypeEavValueDataTable)
//    {
//        return $tasktypeEavValueDataTable->render('tasktype_eav_values.index');
//    }

    public function index()
    {
        return view('tasktype_eav_values.test');
    }

    /**
     * Show the form for creating a new Tasktype_eav_value.
     *
     * @return Response
     */
    public function create()
    {
        return view('tasktype_eav_values.create');
    }

    /**
     * Store a newly created Tasktype_eav_value in storage.
     *
     * @param CreateTasktype_eav_valueRequest $request
     *
     * @return Response
     */
    public function store(CreateTasktype_eav_valueRequest $request)
    {
        $input = $request->all();

        $tasktypeEavValue = $this->tasktypeEavValueRepository->create($input);

        Flash::success('Tasktype Eav Value saved successfully.');

        return redirect(route('tasktypeEavValues.index'));
    }

    /**
     * Display the specified Tasktype_eav_value.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tasktypeEavValue = $this->tasktypeEavValueRepository->findWithoutFail($id);

        if (empty($tasktypeEavValue)) {
            Flash::error('Tasktype Eav Value not found');

            return redirect(route('tasktypeEavValues.index'));
        }

        return view('tasktype_eav_values.show')->with('tasktypeEavValue', $tasktypeEavValue);
    }

    /**
     * Show the form for editing the specified Tasktype_eav_value.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tasktypeEavValue = $this->tasktypeEavValueRepository->findWithoutFail($id);

        if (empty($tasktypeEavValue)) {
            Flash::error('Tasktype Eav Value not found');

            return redirect(route('tasktypeEavValues.index'));
        }

        return view('tasktype_eav_values.edit')->with('tasktypeEavValue', $tasktypeEavValue);
    }

    /**
     * Update the specified Tasktype_eav_value in storage.
     *
     * @param  int              $id
     * @param UpdateTasktype_eav_valueRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTasktype_eav_valueRequest $request)
    {
        $tasktypeEavValue = $this->tasktypeEavValueRepository->findWithoutFail($id);

        if (empty($tasktypeEavValue)) {
            Flash::error('Tasktype Eav Value not found');

            return redirect(route('tasktypeEavValues.index'));
        }

        $tasktypeEavValue = $this->tasktypeEavValueRepository->update($request->all(), $id);

        Flash::success('Tasktype Eav Value updated successfully.');

        return redirect(route('tasktypeEavValues.index'));
    }

    /**
     * Remove the specified Tasktype_eav_value from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $tasktypeEavValue = $this->tasktypeEavValueRepository->findWithoutFail($id);

        if (empty($tasktypeEavValue)) {
            Flash::error('Tasktype Eav Value not found');

            return redirect(route('tasktypeEavValues.index'));
        }

        $this->tasktypeEavValueRepository->delete($id);

        Flash::success('Tasktype Eav Value deleted successfully.');

        return redirect(route('tasktypeEavValues.index'));
    }
}
