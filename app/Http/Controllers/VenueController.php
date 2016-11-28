<?php

namespace App\Http\Controllers;

use App\Forms\VenueForm;
use App\Http\Requests\CreateVenueRequest;
use App\Http\Requests\UpdateVenueRequest;
use App\Repositories\VenueRepository;
use App\Http\Controllers\AppBaseController;
use Distilleries\FormBuilder\Facades\FormBuilder;
use Distilleries\FormBuilder\States\FormStateTrait;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class VenueController extends AppBaseController
{
	use FormStateTrait;

    /** @var  VenueRepository */
    private $venueRepository;

    public function __construct(VenueRepository $venueRepo, FormBuilder $form)
    {
        $this->venueRepository = $venueRepo;
	    $this->form = $form;
    }

    /**
     * Display a listing of the Venue.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->venueRepository->pushCriteria(new RequestCriteria($request));
        $venues = $this->venueRepository->all();

        return view('venues.index')
            ->with('venues', $venues);
    }

	public function create(FormBuilder $formBuilder)
	{
		$form = FormBuilder::create(VenueForm::class, [
			'method' => 'POST',
//			'url' => route('venue.store')
		]);

		return view('venue.create', compact('form'));
	}

	public function store(FormBuilder $formBuilder)
	{
		$form = FormBuilder::create(VenueForm::class);

		if (!$form->isValid())
		{
			return redirect()->back()->withErrors($form->getErrors())->withInput();
		}
	}

	/**
     * Show the form for creating a new Venue.
     *
     * @return Response
     */
//    public function create()
//    {
//        return view('venues.create');
//    }
//
//    /**
//     * Store a newly created Venue in storage.
//     *
//     * @param CreateVenueRequest $request
//     *
//     * @return Response
//     */
//    public function store(CreateVenueRequest $request)
//    {
//        $input = $request->all();
//
//        $venue = $this->venueRepository->create($input);
//
//        Flash::success('Venue saved successfully.');
//
//        return redirect(route('venues.index'));
//    }

    /**
     * Display the specified Venue.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $venue = $this->venueRepository->findWithoutFail($id);

        if (empty($venue)) {
            Flash::error('Venue not found');

            return redirect(route('venues.index'));
        }

        return view('venues.show')->with('venue', $venue);
    }

    /**
     * Show the form for editing the specified Venue.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $venue = $this->venueRepository->findWithoutFail($id);

        if (empty($venue)) {
            Flash::error('Venue not found');

            return redirect(route('venues.index'));
        }

        return view('venues.edit')->with('venue', $venue);
    }

    /**
     * Update the specified Venue in storage.
     *
     * @param  int              $id
     * @param UpdateVenueRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVenueRequest $request)
    {
        $venue = $this->venueRepository->findWithoutFail($id);

        if (empty($venue)) {
            Flash::error('Venue not found');

            return redirect(route('venues.index'));
        }

        $venue = $this->venueRepository->update($request->all(), $id);

        Flash::success('Venue updated successfully.');

        return redirect(route('venues.index'));
    }

    /**
     * Remove the specified Venue from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $venue = $this->venueRepository->findWithoutFail($id);

        if (empty($venue)) {
            Flash::error('Venue not found');

            return redirect(route('venues.index'));
        }

        $this->venueRepository->delete($id);

        Flash::success('Venue deleted successfully.');

        return redirect(route('venues.index'));
    }
}
