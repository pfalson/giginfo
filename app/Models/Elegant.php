<?php

namespace App;

use Eloquent;
use Validator;

/**
 * Created by PhpStorm.
 * 
 * User: pfalson
 * Date: 8/4/2016
 * Time: 1:34 PM
 *
 * @mixin Eloquent
 */
class Elegant extends Eloquent
{
	/**
	 * @var string
	 */
	private static $lastError;

	public static $rules = [];

	/**
	 * @return string
	 */
	public static function getLastError(): string
	{
		return self::$lastError ?? '';
	}

	/**
	 * @var string
	 */
	private $errors;

	/**
	 * @return string
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * @param mixed[] $data
	 * @return bool
	 */
	public function validate($data)
	{
		if (!empty($this->rules))
		{
			$v = Validator::make($data, $this->rules);

			if ($v->fails())
			{
				static::$lastError = $this->errors = $v->errors();
				return false;
			}
		}

		return true;
	}

	/**
	 * @param array $options
	 * @return bool
	 */
	public function save(array $options = [])
	{
		if (!$this->validate($this->attributes))
		{
			return false;
		}

		return parent::save($options);
	}

	/**
	 * @param array $attributes
	 * @return bool|static
	 */
	public static function create(array $attributes = [])
	{
		$model = new static($attributes);

		return $model->save() ? $model : false;
	}
}