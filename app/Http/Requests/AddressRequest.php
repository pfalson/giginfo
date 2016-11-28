<?php

namespace App\Http\Requests;

use App\Http\Controllers\Admin\AddressCrudController;
use Flash;
use Symfony\Component\HttpFoundation\ParameterBag;

class AddressRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
            // 'name' => 'required|min:5|max:255'
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
            //
        ];
    }

	/**
	 * @param ParameterBag $requestParams
	 */
	public static function buildAddress($requestParams)
	{
		$address = AddressCrudController::matchAddress($requestParams->all());

		if ($address == null)
		{
			$address_id = null;
			Flash::error('Failed to build an address');
		}
		else
		{
			$address_id = $address->id;
		}

		$attributes = $requestParams->all();
		$attributes['address_id'] = $address_id;
		$requestParams->replace($attributes);
	}
}