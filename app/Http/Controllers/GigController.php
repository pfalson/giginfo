<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGigRequest;
use App\Http\Requests\UpdateGigRequest;
use App\Repositories\GigRepository;
use Illuminate\Http\Request;
use Flash;
use Intervention\Image\Facades\Image;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class GigController extends AppBaseController
{
	/** @var  GigRepository */
	private $gigRepository;

	public function __construct(GigRepository $gigRepo)
	{
		$this->gigRepository = $gigRepo;
	}

	/**
	 * Display a listing of the Gig.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		$this->gigRepository->pushCriteria(new RequestCriteria($request));
		$gigs = $this->gigRepository->all();

		return view('gigs.index')
			->with('gigs', $gigs);
	}

	/**
	 * Show the form for creating a new Gig.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('gigs.create');
	}

	/**
	 * Store a newly created Gig in storage.
	 *
	 * @param CreateGigRequest $request
	 *
	 * @return Response
	 */
	public function store(CreateGigRequest $request)
	{
		$input = $request->all();

		$this->gigRepository->create($input);

		Flash::success('Gig saved successfully.');

		return redirect(route('gigs.index'));
	}

	/**
	 * Display the specified Gig.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$gig = $this->gigRepository->findWithoutFail($id);

		if (empty($gig))
		{
			Flash::error('Gig not found');

			return redirect(route('gigs.index'));
		}

		return view('gigs.show')->with('gig', $gig);
	}

	/**
	 * Show the form for editing the specified Gig.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$gig = $this->gigRepository->findWithoutFail($id);

		if (empty($gig))
		{
			Flash::error('Gig not found');

			return redirect(route('gigs.index'));
		}

		return view('gigs.edit')->with('gig', $gig);
	}

	/**
	 * Update the specified Gig in storage.
	 *
	 * @param  int $id
	 * @param UpdateGigRequest $request
	 *
	 * @return Response
	 */
	public function update($id, UpdateGigRequest $request)
	{
		$gig = $this->gigRepository->findWithoutFail($id);

		if (empty($gig))
		{
			Flash::error('Gig not found');

			return redirect(route('gigs.index'));
		}

		$file = $request->file('poster');
		$img = Image::make($file);
		Response::make($img->encode('jpeg'));
		$attributes = $request->all();
		$attributes['poster'] = $img->getEncoded();

		$this->gigRepository->update($attributes, $id);

		Flash::success('Gig updated successfully.');

		return redirect(route('gigs.index'));
	}

	/**
	 * Remove the specified Gig from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$gig = $this->gigRepository->findWithoutFail($id);

		if (empty($gig))
		{
			Flash::error('Gig not found');

			return redirect(route('gigs.index'));
		}

		$this->gigRepository->delete($id);

		Flash::success('Gig deleted successfully.');

		return redirect(route('gigs.index'));
	}

	// not currently used
	private function storePicture($request)
	{
		$fname = $request->file($request->poster);
		$source = \Input::file('poster');
		$img = Image::make($source);
		Response::make($img->encode('jpeg'));

		return $img;
	}

	public function poster($id)
	{
		$gig = $this->gigRepository->findWithoutFail($id);

		if (empty($gig))
		{
			abort(404);
		}

		return $gig->poster;
	}
}