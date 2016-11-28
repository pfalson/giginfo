<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\VenueRequest as StoreRequest;
use App\Http\Requests\VenueRequest as UpdateRequest;
use URL;

class VenueCrudController extends CrudController
{

	public function setUp()
	{

		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->crud->setModel("App\Models\Venue");
		$this->crud->setRoute("admin/venue");
		$this->crud->setEntityNameStrings('venue', 'venues');

		$this->crud->addColumn([
			'name'  => 'name',
			'label' => 'Name'
		]);

		$this->crud->addColumn([
			'name'  => 'address',
			'label' => 'Address'
		]);

		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->crud->addField(
			[
				'name'  => 'redirect_after_save',
				'label' => '',
				'value' => URL::previous(),
				'type'  => 'hidden'
			]);

		// ------ CRUD FIELDS
		$this->crud->addField([
			'name'           => 'details',
			'label'          => 'Address',
			'type'           => 'google_address',
			'address_type'   => 'establishment',
			'google_api_key' => env('GOOGLE_MAP_JS_API_KEY'),
			'current'        => false,
			'components'     => [
				'name'          => [
					'name'     => 'name',
					'label'    => 'Name',
					'readOnly' => true
				],
				'website'       => [
					'name'  => 'website',
					'label' => 'Website'
				],
				'phone'         => [
					'name'     => 'international_phone_number',
					'label'    => 'Phone',
					'readOnly' => true
				],
				'longitude'     => [
					'name'       => 'location',
					'category'   => 'geometry',
					'function'   => 'lng',
					'field_type' => 'hidden',
				],
				'latitude'      => [
					'name'       => 'location',
					'category'   => 'geometry',
					'function'   => 'lat',
					'field_type' => 'hidden',
				],
				'street_number' => [
					'name'     => 'street_number',
					'category' => 'address_components',
					'label'    => 'Number',
					'type'     => 'short_name',
					'readOnly' => true
				],
				'street'        => [
					'name'     => 'route',
					'category' => 'address_components',
					'label'    => 'Street',
					'type'     => 'short_name',
					'readOnly' => true
				],
				'postal_code'   => [
					'name'     => 'postal_code',
					'category' => 'address_components',
					'label'    => 'Postal Code',
					'type'     => 'short_name',
					'readOnly' => true
				],
				'city'          => [
					'name'     => 'locality',
					'category' => 'address_components',
					'label'    => 'City',
					'type'     => 'long_name',
					'readOnly' => true
				],
				'abbr'          => [
					'name'       => 'administrative_area_level_1',
					'category'   => 'address_components',
					'label'      => 'State',
					'type'       => 'short_name',
					'field_type' => 'hidden',
					'readOnly'   => true
				],
				'state'         => [
					'name'     => 'administrative_area_level_1',
					'category' => 'address_components',
					'label'    => 'State',
					'type'     => 'long_name',
					'readOnly' => true
				],
				'province'      => [
					'name'       => 'administrative_area_level_2',
					'category'   => 'address_components',
					'label'      => 'Province',
					'type'       => 'short_name',
					'field_type' => 'hidden',
					'readOnly'   => true
				],
				'sortname'      => [
					'name'       => 'country',
					'category'   => 'address_components',
					'label'      => 'Country',
					'type'       => 'short_name',
					'field_type' => 'hidden',
					'readOnly'   => true
				],
				'country'       => [
					'name'     => 'country',
					'category' => 'address_components',
					'label'    => 'Country',
					'type'     => 'long_name',
					'readOnly' => true
				],
			],
		]);

		$this->crud->addField(
			[
				'label' => "Facebook",
				'type'  => 'text',
				'name'  => 'facebook',
				'hint'  => 'Enter the page name/path that follows www.facebook/'
			]);

		$this->crud->addField(
			[
				'type' => 'hidden',
				'name' => 'address_id'
			]);

		// ------ CRUD FIELDS
		// $this->crud->addField($options, 'update/create/both');
		// $this->crud->addFields($array_of_arrays, 'update/create/both');
		// $this->crud->removeField('name', 'update/create/both');
		// $this->crud->removeFields($array_of_names, 'update/create/both');

		// ------ CRUD COLUMNS
		// $this->crud->addColumn(); // add a single column, at the end of the stack
		// $this->crud->addColumns(); // add multiple columns, at the end of the stack
		// $this->crud->removeColumn('column_name'); // remove a column from the stack
		// $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
		// $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
		// $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

		// ------ CRUD BUTTONS
		// possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
		// $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
		// $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
		// $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
		// $this->crud->removeButton($name);
		// $this->crud->removeButtonFromStack($name, $stack);

		// ------ CRUD ACCESS
		$this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
		// $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

		// ------ CRUD REORDER
		// $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
		// NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

		// ------ CRUD DETAILS ROW
		// $this->crud->enableDetailsRow();
		// NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
		// NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

		// ------ REVISIONS
		// You also need to use \Venturecraft\Revisionable\RevisionableTrait;
		// Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
		$this->crud->allowAccess('revisions');

		// ------ AJAX TABLE VIEW
		// Please note the drawbacks of this though:
		// - 1-n and n-n columns are not searchable
		// - date and datetime columns won't be sortable anymore
		// $this->crud->enableAjaxTable();


		// ------ DATATABLE EXPORT BUTTONS
		// Show export to PDF, CSV, XLS and Print buttons on the table view.
		// Does not work well with AJAX datatables.
		// $this->crud->enableExportButtons();

		// ------ ADVANCED QUERIES
		// $this->crud->addClause('active');
		// $this->crud->addClause('type', 'car');
		// $this->crud->addClause('where', 'name', '==', 'car');
		// $this->crud->addClause('whereName', 'car');
		// $this->crud->addClause('whereHas', 'posts', function($query) {
		//     $query->activePosts();
		// });
		// $this->crud->orderBy();
		// $this->crud->groupBy();
		// $this->crud->limit();
	}

	public function store(StoreRequest $request)
	{
		return parent::storeCrud($request);
	}

	public function update(UpdateRequest $request)
	{
		return parent::updateCrud($request);
	}
}
