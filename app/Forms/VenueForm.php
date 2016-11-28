<?php namespace App\Forms;

use Distilleries\FormBuilder\FormValidator;

class VenueForm extends FormValidator
{
	public static $rules        = [];
	public static $rules_update = null;

	public function buildForm()
	{
		$this
			->add('name', 'textarea')
			->add('address', 'address_picker', [
				'default_value' => [
					'lat' => 10,
					'lng' => 10,
					'street' => '42 Wallaby Way',
					'city' => 'Sydney',
					'country' => 'Australia',
					'default' => '42 Wallaby Way, Sydney, Australia',
				]
			]);
         $this->addDefaultActions();
    }
}