<?php namespace App\Forms;

use Distilleries\FormBuilder\FormValidator;

class AddressForm extends FormValidator
{
    public static $rules        = [];
    public static $rules_update = null;

    public function buildForm()
    {
        $this
	        ->add('city_id', 'choice_ajax_add', [
		        'label'      => 'City',
		        'action'     => route('city.ajaxsearch'),
		        'default_value' => $this->model->city_id,
		        'validation' => 'required',
		        'minimumInputLength' => 0,
		        'add' => true,
		        'create_route' => route('city.create'),
		        'edit_route' => route('city.edit', (($this->model) ? $this->model->city_id : null)),
		        'formatter'  => [
			        'id'      => 'id',
			        'name' => 'name',
		        ],
	        ])
            ->add('street_number', 'textarea')
	        ->add('street_id', 'choice_ajax_add', [
		        'label'      => 'Street',
		        'action'     => route('street.ajaxsearch'),
		        'default_value' => $this->model->street_id,
		        'validation' => 'required',
		        'minimumInputLength' => 0,
		        'add' => true,
		        'create_route' => route('street.create'),
		        'edit_route' => route('street.edit', (($this->model) ? $this->model->street_id : null)),
		        'formatter'  => [
			        'id'      => 'id',
			        'name' => 'name',
		        ],
	        ]);

         $this->addDefaultActions();
    }
}