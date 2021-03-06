<?php

namespace App\Validation;

use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Validator;

class CustomValidation extends Validator
{
	// Laravel keeps a certain convention for rules
	// So the function is called validateGreaterThen
	// Then the rule is greater_then

	// A validation rule accepts three parameters
	// $attribute This is the name of the input
	// $value This is the value of the input
	// $parameters This is a parameter for the rule, so greater_then:1,2 has two parameters
	// the $parameters are returned as an array so for the first parameter: $parameters[0]

	// Now that we know how a rule works let's create one
	/**
	 * $attribute Input name
	 * $value Input value
	 * $parameters Table, field1
	 */
	public function validateUniqueWith($attribute, $value, $parameters)
	{
		// Now that we have our data we can check for the data

		// We first grab the correct table which is passed to the function
		// Now we need to do some checking using Eloquent
		// If you don't understand this, please let me know
		$result = DB::table($parameters[0])->where(function ($query) use ($attribute, $value, $parameters)
		{
			$column = null;
			foreach ($parameters as $parameter)
			{
				if (substr($parameter, 0, 1) === '@')
				{
					$param_value = array_get($this->getData(), substr($parameter, 1));
					if ($param_value !== null)
					{
						if ($parameter === '@id')
						{
							$column = 'id';
							$op = '!=';
						}
						else
						{
							$op = '=';
						}

						$query = $query->where($column, $op, $param_value);
					}
				}
				$column = $parameter;
			}
			/** @var Builder $query */
			$query->where($attribute, $value)
				->whereNull('deleted_at');
        })->first();

		return $result ? false : true;
	}

	public function replaceUniqueWith($message, $attribute, $rule, $parameters)
	{
		foreach ($this->getData() as $key => $value)
		{
			$message = str_replace('@' . $key . '@', $value, $message);
		}
		return $message;
	}
}