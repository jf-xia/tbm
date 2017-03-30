<?php

namespace App\Http\Controllers;

use App\DataTables\TechnicalsupportDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTechnicalsupportRequest;
use App\Http\Requests\UpdateTechnicalsupportRequest;
use App\Repositories\TechnicalsupportRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class TechnicalsupportController extends AppBaseController
{
    /** @var  TechnicalsupportRepository */
    private $technicalsupportRepository;

    public function __construct(TechnicalsupportRepository $technicalsupportRepo)
    {
        $this->technicalsupportRepository = $technicalsupportRepo;
    }

    /**
     * Display a listing of the Technicalsupport.
     *
     * @param TechnicalsupportDataTable $technicalsupportDataTable
     * @return Response
     */
    public function index(TechnicalsupportDataTable $technicalsupportDataTable)
    {
        return $technicalsupportDataTable->render('technicalsupports.index');
    }

    /**
     * Show the form for creating a new Technicalsupport.
     *
     * @return Response
     */
    public function create()
    {
        return view('technicalsupports.create');
    }

    /**
     * Store a newly created Technicalsupport in storage.
     *
     * @param CreateTechnicalsupportRequest $request
     *
     * @return Response
     */
    public function store(CreateTechnicalsupportRequest $request)
    {
        $input = $request->all();

        $technicalsupport = $this->technicalsupportRepository->create($input);

        Flash::success('Technicalsupport saved successfully.');

        return redirect(route('technicalsupports.index'));
    }

    /**
     * Display the specified Technicalsupport.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $technicalsupport = $this->technicalsupportRepository->findWithoutFail($id);

        if (empty($technicalsupport)) {
            Flash::error('Technicalsupport not found');

            return redirect(route('technicalsupports.index'));
        }

        return view('technicalsupports.show')->with('technicalsupport', $technicalsupport);
    }

    /**
     * Show the form for editing the specified Technicalsupport.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $technicalsupport = $this->technicalsupportRepository->findWithoutFail($id);

        if (empty($technicalsupport)) {
            Flash::error('Technicalsupport not found');

            return redirect(route('technicalsupports.index'));
        }

        return view('technicalsupports.edit')->with('technicalsupport', $technicalsupport);
    }

    /**
     * Update the specified Technicalsupport in storage.
     *
     * @param  int              $id
     * @param UpdateTechnicalsupportRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTechnicalsupportRequest $request)
    {
        $technicalsupport = $this->technicalsupportRepository->findWithoutFail($id);

        if (empty($technicalsupport)) {
            Flash::error('Technicalsupport not found');

            return redirect(route('technicalsupports.index'));
        }

        $technicalsupport = $this->technicalsupportRepository->update($request->all(), $id);

        Flash::success('Technicalsupport updated successfully.');

        return redirect(route('technicalsupports.index'));
    }

    /**
     * Remove the specified Technicalsupport from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $technicalsupport = $this->technicalsupportRepository->findWithoutFail($id);

        if (empty($technicalsupport)) {
            Flash::error('Technicalsupport not found');

            return redirect(route('technicalsupports.index'));
        }

        $this->technicalsupportRepository->delete($id);

        Flash::success('Technicalsupport deleted successfully.');

        return redirect(route('technicalsupports.index'));
    }
}
