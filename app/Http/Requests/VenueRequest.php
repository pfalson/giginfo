<?php

namespace App\Http\Requests;

use Symfony\Component\HttpFoundation\ParameterBag;

class VenueRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
	protected static $rules = [
		'address_id' => 'required',
		'name' => 'required|unique_with:venues,name,@id,address_id,@address_id'
	];

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
	 * @return array
	 */
	public function rules()
	{
		/** @var ParameterBag $requestParams */
		$requestParams = $this->request;

		AddressRequest::buildAddress($requestParams);

		/** @noinspection PhpUndefinedFieldInspection */
		return array_map(
			function ($v) use ($requestParams)
			{
				$v_params = explode(',', $v);
				foreach ($v_params as &$v_param)
				{
					if (substr($v_param, 0, 1) === '@')
					{
						$fld = substr($v_param, 1);
						if ($requestParams->has($fld))
						{
							$v_param = $requestParams->get($fld);
						}
					}
				}
				return implode(',', $v_params);
			},
			static::$rules
		);
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
			'address_id.required' => 'Please ensure all the address fields are filled',
			'name.unique_with' => '"@name@" has already been used for this address'
		];
	}
}