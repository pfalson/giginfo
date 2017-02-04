<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\ArtistMember;
use App\Models\Gig;
use App\Models\Member;
use App\Models\VenueType;
use App\Repositories\GigRepository;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use File;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Input;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Session;
use View;

class UserController extends AppBaseController
{
	public function __construct()
	{
	}

	public function show()
	{
	}

	/**
	 * Show the form for editing the specified Gig.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit()
	{
		/** @noinspection PhpUndefinedMethodInspection */
		$user = User::where('users.id', Auth::user()->id)->details()->firstOrFail();

		/** @noinspection PhpUndefinedMethodInspection */
		return view('user.edit')->with(compact('user'));
	}

	/**
	 * Update the specified Gig in storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update($id)
	{
		DB::beginTransaction();

		User::where('id', $id)->update(['name' => Input::get('name')]);
		Member::where('user_id', $id)->update(['biography' => Input::get('biography')]);

		DB::commit();

		/** @noinspection PhpUndefinedMethodInspection */
		\Alert::success('User updated successfully.')->flash();

		return redirect(route('home'));
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
		/** @noinspection PhpUndefinedFieldInspection */
		$gig = $this->gigRepository->findWithoutFail($id);

		if (empty($gig))
		{
			Flash::error('Gig not found');

			return redirect(route('gigs.index'));
		}

		/** @noinspection PhpUndefinedFieldInspection */
		$this->gigRepository->delete($id);

		Flash::success('Gig deleted successfully.');

		return redirect(route('gigs.index'));
	}

	public function poster($id)
	{
		/** @noinspection PhpUndefinedFieldInspection */
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
		/** @noinspection PhpUndefinedFieldInspection */
		$gig = $this->gigRepository->findWithoutFail($id);

		if (empty($gig))
		{
			abort(404);
		}

		/** @noinspection PhpUndefinedMethodInspection */
		return view('ical')->with(compact('gig'));
	}

	/**
	 * @param Request $request
	 * @return View
	 */
	protected function applyFilter(Request $request)
	{
//		$timezone = Session::get('tz');

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
			/** @noinspection PhpUndefinedMethodInspection */
			return view('gigs.index')->with('distance', GigRepository::defaultDistance);
		}

		$distance = array_get($filter, 'distance');
		$genre = array_get($filter, 'genre', []);
		$artist = array_get($filter, 'artist', []);
		$start = Carbon::yesterday();

		$today = array_get($filter, 'today');

		if (!$today)
		{
			$start = array_get($filter, 'fake_start', Carbon::today()->toDateString());
			$finish = array_get($filter, 'fake_finish');

			$start = Carbon::parse($start);
			if (!empty($finish))
				$finish = Carbon::parse($finish);
		}

		/** @noinspection PhpUndefinedFieldInspection */
		$this->gigRepository->pushCriteria(new RequestCriteria($request));

//		$artists = Artist::details()->pluck('name', 'id')->toArray();

		/** @noinspection PhpUndefinedFieldInspection */
		/** @var Gig $gigs */
		$gigs = $this->gigRepository->orderBy('start')->all()
			->where('start', '>=', $start);
//			->where('finish', '>', Carbon::now());

		if ($latitude > 0)
		{
			$distanceSQL = DB::select("-- noinspection SqlDialectInspection
SELECT id FROM (SELECT id, ( 6371 * acos( cos( radians("
				. $latitude . ") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians("
				. $longitude . ") ) + sin( radians("
				. $latitude . ") ) * sin( radians( latitude ) ) ) ) AS distance FROM addresses HAVING distance < "
				. $distance . " ORDER BY distance) as distances");

			$addressIDs = [];
			foreach ($distanceSQL as $obj)
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

		/** @noinspection PhpUndefinedMethodInspection */
		$finish = array_get($filter, 'fake_finish', explode(' ', $gigs->last()['start'])[0]);
		$finish = Carbon::parse($finish);

		$todaysGigs = $gigs->where('start', '<=', Carbon::now())->where('start', '<', Carbon::tomorrow());

		$start = array_get($filter, 'fake_start');
		$finish = array_get($filter, 'fake_finish', $finish);

		$showFilterHidden = array_get($filter, 'showFilterHidden', 'none');
		if ($today || ($todaysGigs->count() > 0 && $showFilterHidden == 'none'))
		{
			$gigs = $todaysGigs;
			$today = true;
		}

		$showMapHidden = array_get($filter, 'showMapHidden', 'none');

		/** @noinspection PhpUndefinedMethodInspection */
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