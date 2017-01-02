<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\AddressCrudController;
use App\Http\Requests\CreateGigRequest;
use App\Http\Requests\UpdateGigRequest;
use App\Models\Artist;
use App\Models\ArtistMember;
use App\Models\VenueType;
use App\Repositories\GigRepository;
use Carbon\Carbon;
use DB;
use File;
use Illuminate\Http\Request;
use Flash;
use Intervention\Image\Facades\Image;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Session;

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
		return $this->applyFilter($request);
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
		return $this->applyFilter($request);
	}

	/**
	 * Display the specified Gig.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id, Request $request)
	{
		$gig = $this->gigRepository->findWithoutFail($id);

		if (empty($gig))
		{
			Flash::error('Gig not found');

			return redirect(route('gigs.index'));
		}

		$current = AddressCrudController::getLocation($request);

		return view('gigs.show')->with(compact('gig', 'current'));
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

	public function poster($id)
	{
		$gig = $this->gigRepository->findWithoutFail($id);

		if (empty($gig))
		{
			abort(404);
		}

		$response = '';
		if ($gig->poster)
		{
			$path = public_path() . '/' . $gig->poster;

			if (!File::exists($path)) abort(404);

			$file = File::get($path);
			$type = File::mimeType($path);

			$response = Response::make($file, 200);
			$response->header("Content-Type", $type);
		}

		return $response;
	}

	public function ical($id)
	{
		$gig = $this->gigRepository->findWithoutFail($id);

		if (empty($gig))
		{
			abort(404);
		}

		return view('ical')->with(compact('gig'));
	}

	protected function applyFilter(Request $request)
	{
		$timezone = Session::get('tz');

		$filter = [];
		foreach ($request->all() as $key => $value)
		{
			if (!empty($value))
			{
				$filter[$key] = $value;
			}
		}

		$venue_type = array_get($filter, 'venue_type', 'all');
		$latitude = array_get($filter, 'latitude', 0);
		$longitude = array_get($filter, 'longitude', 0);

		if (!isset($filter['venue_type']) && $longitude == 0)
		{
			return view('gigs.index');
		}

		$distance = array_get($filter, 'distance', 20);
		$genre = array_get($filter, 'genre', []);
		$artist = array_get($filter, 'artist', []);
		$start = Carbon::yesterday();

		$today = array_get($filter, 'today');

		if (!$today)
		{
			$start = array_get($filter, 'fake_start', Carbon::yesterday()->toDateString());
			$finish = array_get($filter, 'fake_finish');

			$start = Carbon::parse($start);
			if (!empty($finish))
				$finish = Carbon::parse($finish);
		}

		$this->gigRepository->pushCriteria(new RequestCriteria($request));

		$artists = Artist::details()->pluck('name', 'id')->toArray();

		$gigs = $this->gigRepository->orderBy('start')->all()
			->where('start', '>=', $start);
//			->where('finish', '>', Carbon::now());

		if ($latitude > 0)
		{
			$distansSQL = DB::select("SELECT id FROM (SELECT id, ( 6371 * acos( cos( radians("
				. $latitude . ") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians("
				. $longitude . ") ) + sin( radians("
				. $latitude . ") ) * sin( radians( latitude ) ) ) ) AS distance FROM addresses HAVING distance < "
				. $distance . " ORDER BY distance) as distances");

			$addressIDs = [];
			foreach ($distansSQL as $obj)
			{
				$addressIDs[] = $obj->id;
			}

			$gigs = $gigs->whereIn('address_id', $addressIDs);
		}

		$artists = $gigs->pluck('artistName', 'artist_id');

		if (!$today && !empty($finish))
		{
			$gigs = $gigs->where('start', '<=', $finish);
		}

		if ($venue_type !== 'all')
		{
			$venueType_id = VenueType::where('name', $venue_type)->pluck('id')[0];
			$gigs = $gigs->where('venuetype_id', $venueType_id);
		}

		if (!empty($genre) && empty($artists))
		{
			$artist = ArtistMember::whereIn('genre_id', $genre)->pluck('artist_id')->toArray();
		}

		if (!empty($artist))
		{
			$gigs = $gigs->whereIn('artist_id', $artist);
		}

		$finish = array_get($filter, 'fake_finish', explode(' ', $gigs->last()['start'])[0]);
		$finish = Carbon::parse($finish);

		$todaysGigs = $gigs->where('finish', '<', Carbon::tomorrow());

		$start = array_get($filter, 'fake_start');
		$finish = array_get($filter, 'fake_finish', $finish);

		$showFilterHidden = array_get($filter, 'showFilterHidden', 'none');
		if ($today || ($todaysGigs->count() > 0 && $showFilterHidden == 'none'))
		{
			$gigs = $todaysGigs;
			$today = true;
		}

		$showMapHidden = array_get($filter, 'showMapHidden', 'none');

		return view('gigs.browse')
			->with(compact(
				'gigs',
				'latitude',
				'longitude',
				'distance',
				'genre',
				'artist',
				'artists',
				'today',
				'start',
				'finish',
				'venue_type',
				'showFilterHidden',
				'showMapHidden'
			));
	}
}