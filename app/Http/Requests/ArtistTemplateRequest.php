<?php

namespace App\Http\Requests;

class ArtistTemplateRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
			'artist_id' => 'required|exists:artists,id',
			'name'      => 'required|unique_with:artist_templates,name,@id,artist_id,@artist_id'
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
			'artist_id.required' => 'Please choose an artist',
			'name.unique_with' => '"@name@" has already been used'
		];
	}
}