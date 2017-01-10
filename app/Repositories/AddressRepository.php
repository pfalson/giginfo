<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\Timezone;
use DB;
use Exception;
use Illuminate\Support\Facades\Input;
use InfyOm\Generator\Common\BaseRepository;
use Session;
use stdClass;

class AddressRepository extends BaseRepository
{
	/**
	 * @var array
	 */
	protected $fieldSearchable = [
		'city_id',
		'street_number',
		'street_id'
	];

	/**
	 * Configure the Model
	 **/
	public function model()
	{
		return Address::class;
	}

	public static function retrieveTimeZone($longitude, $latitude)
	{
		$url = 'https://maps.googleapis.com/maps/api/timezone/json?timestamp=0';
		$url .= '&key=' . env('GOOGLE_TZ_JS_API_KEY');
		$url .= '&location=' . $latitude . ',' . $longitude;
		try
		{
			$result = \GuzzleHttp\json_decode(file_get_contents($url));
		} catch (Exception $ex)
		{
			$result = new stdClass();
			$result->timeZoneId = Session::get('tz');
		}

		return $result;
	}

	public static function createTimeZone($longitude, $latitude)
	{
		$tz = AddressRepository::retrieveTimeZone($longitude, $latitude);
		$timezone = Timezone::firstOrCreate([
			'name'   => $tz->timeZoneId,
			'zone'   => $tz->timeZoneName,
			'offset' => $tz->rawOffset
		]);

		return $timezone;
	}

	public static function getCityFromPosition()
	{
		$latitude = Input::get('latitude');
		$longitude = Input::get('longitude');
		$distance = Input::get('distance') ?? 50;
		$distanceSQL = DB::select("SELECT id FROM (SELECT id, ( 6371 * acos( cos( radians("
			. $latitude . ") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians("
			. $longitude . ") ) + sin( radians("
			. $latitude . ") ) * sin( radians( latitude ) ) ) ) AS distance FROM addresses HAVING distance < "
			. $distance . " ORDER BY distance LIMIT 1) as distances");

		$result = [];

		foreach ($distanceSQL as $address)
		{
			$city = Address::with('postalcode.city')->where('addresses.id', $address->id)->first();
			$result = $city->postalcode->city;
		}

		return $result;
	}
}
