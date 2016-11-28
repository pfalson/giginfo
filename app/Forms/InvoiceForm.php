<?php

namespace App\Forms;

use App\Models\BreedshipType;
use Distilleries\FormBuilder\FormValidator;
use App\Models\Customer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;



class InvoiceForm extends FormValidator
{
	public function buildForm()
	{
		$this
			->add('id', 'hidden')
			->add('invoicenumber', 'text', [
				'label' => 'Factuurnummer',
				'validation' => 'required',
				'default_value' => $this->model->invoicenumber
			])
			->add('invoicedate', 'date', [
				'label' => 'Factuurdatum',
				'default_value' => $this->model->invoicedate
			])
			->add('is_paid', 'choice',  [
				'label'=> 'Betaalstatus',
				'expanded' => true,
				'choices' => [
					'0'=>'Openstaand',
					'1'=>'Betaald'
				],
				'default_value' => $this->model->is_paid
			])
			->add('reminded', 'date',  [
				'label'=> 'Herinnering verstuurd',
				'default_value' => ''
			])
			->add('member_id', 'choice_ajax_add', [
				'label'      => 'Lid',
				'action'     => route('member.ajaxsearch'),
				'default_value' => $this->model->member_id,
				'validation' => 'required',
				'minimumInputLength' => 0,
				'add' => true,
				'create_route' => route('member.create'),
				'edit_route' => route('member.edit', (($this->model) ? $this->model->member_id : null)),
				'formatter'  => [
					'id'      => 'id',
					'libelle' => 'firstname, lastname',
				],
			])

			->add('address_id', 'choice_ajax_add', [
				'label'      => 'Adres',
				'action'     => route('address.ajaxsearch'),
				'default_value' => $this->model->address_id,
				'validation' => 'required',
				'minimumInputLength' => 0,
				'add' => true,
				'create_route' => route('address.create'),
				'edit_route' => route('address.edit', (($this->model) ? $this->model->address_id : null)),
				'formatter'  => [
					'id'      => 'id',
					'libelle' => 'street,zipcode,city',
				],
			])
			->add('submit', 'submit', ['label' => 'Save', 'attr' => ['class' => 'btn'],], false, true);
	}
}