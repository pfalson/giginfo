<?php

namespace App\Repositories;

use App\Address;
use App\Models\Timezone;
use Exception;
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
}
