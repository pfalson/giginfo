<?php
/**
 * Created by PhpStorm.
 * User: pfalson
 * Date: 11/16/2016
 * Time: 8:29 AM
 */

namespace App\Providers;


use App\Validation\CustomValidation;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{

	public function register()
	{
	}

	public function boot()
	{
		// Need to override the default validator with our own validator
		// We can do that by using the resolver function
		$this->app->validator->resolver(function ($translator, $data, $rules, $messages)
		{
			// This class will hold all our custom validations
			return new CustomValidation($translator, $data, $rules, $messages);
		});

//		Validator::extend('unique_with', function ($attribute, $value, $parameters, $validator)
//		{
//			return new CustomValidation($translator, $data, $rules, $messages);
//			if (!empty($value) && (strlen($value) % 2) == 0)
//			{
//
//				return true;
//
//			}
//
//			return false;
//
//		});
	}
}