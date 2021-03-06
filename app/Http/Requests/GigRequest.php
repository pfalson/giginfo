<?php

namespace App\Http\Requests;

use App\Models\Venue;
use App\Models\VenueType;
use App\Repositories\AddressRepository;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\ParameterBag;

class GigRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		// only allow updates if the user is logged in
		return \Auth::check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'start'     => 'required|unique_with:gigs,name,@id,artist_id,@artist_id',
			'finish'    => 'required',
			'artist_id' => 'required|exists:artists,id',
			'venue_id'  => 'required|exists:venues,id',
//			'name'      => 'required|unique_with:gigs,name,@id,artist_id,@artist_id'
		];
	}

	/**
	 * Get the validation attributes that apply to the request.
	 *
	 * @return array
	 */
	public function attributes()
	{
		return [
			//
		];
	}

	/**
	 * Get the validation messages that apply to the request.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'venue_id.required' => 'Please choose a venue',
			'name.unique_with' => '"@name@" has already been used'
		];
	}

	protected function getValidatorInstance()
	{
		$modifiedAttributes = [];

		/** @var ParameterBag $requestParams */
		$requestParams = $this->request;
		$attributes = $requestParams->all();
		if (!empty($attributes['when']) && !empty($attributes['starttime']))
		{
			$venue = Venue::where('venues.id', $attributes['venue_id'])->first();
			$start = $attributes['when'] . ' ' . $attributes['starttime'];

			if (!empty($attributes['finish']))
			{
				$finish = $attributes['finish'];
				if (strstr($finish, '-') === false)
				{
					$finish = $attributes['when'] . ' ' . $finish;
				}

				$tz = $venue !== null ? $venue->timezone : AddressRepository::retrieveTimeZone($attributes['longitude'], $attributes['latitude'])->timeZoneId;

				$starttime = Carbon::parse($start, $tz);
				$finishtime = Carbon::parse($finish, $tz);
				while ($finishtime->lt($starttime))
				{
					$finishtime->addDay(1);
				}
				$modifiedAttributes['start'] = $starttime->toDateTimeString();
				$modifiedAttributes['finish'] = $finishtime->toDateTimeString();
			}
		}

		if ($requestParams->get('venuetype') === '2')
		{
			AddressRequest::buildAddress($requestParams);

			$attributes = $requestParams->all();
			$address_id = array_get($attributes, 'address_id');

			if (!empty($address_id))
			{
				$venuetype = VenueType::where('name', 'House')->get()->pluck('id')[0];

				$args = ['venuetype_id' => $venuetype, 'address_id' => $address_id];

				$venue = Venue::where($args)->first();

				foreach (['name', 'facebook', 'phone'] as $attr)
				{
					$args['venues.' . $attr] = array_get($attributes, $attr);
				}

				if ($venue !== null)
				{
					$venue->save($args);
				}
				else
				{
					$venue = Venue::firstOrCreate($args);
				}

				$modifiedAttributes['venue_id'] = $venue->id;
			}
		}

		// Add new data field before it gets sent to the validator
		$this->merge($modifiedAttributes);

		$requestParams->replace(array_merge($attributes, $modifiedAttributes));

		// Fire the parent getValidatorInstance method
		return parent::getValidatorInstance();
	}
}