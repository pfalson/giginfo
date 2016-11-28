<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\GigRequest as StoreRequest;
use App\Http\Requests\GigRequest as UpdateRequest;

class GigCrudController extends CrudController
{

	public function setUp()
	{

		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->crud->setModel("App\Models\Gig");
		$this->crud->setRoute("admin/gig");
		$this->crud->setEntityNameStrings('gig', 'gigs');

		$this->crud->addColumn(
			[
				'name'      => 'venue_id',
				'label'     => 'Venue',
				'type'      => 'select',
				'entity'    => 'venue',
				'model'     => 'App\Models\Venue',
				'attribute' => 'name'
			]
		);

		$this->crud->addColumn(
			[
				'name'  => 'name',
				'label' => 'Name',
				'type'  => 'text'
			]
		);

		$this->crud->addColumn(
			[
				'name'  => 'start',
				'label' => 'When',
				'type'  => 'text'
			]
		);

		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

		$this->crud->addField(
			[
				'wrapperAttributes' => ['onclick' => 'toggleRadio();'],
				'name'              => 'venuetype', // the name of the db column
				'label'             => 'Venue Type', // the input label
				'type'              => 'radio',
				'default'           => '1',
				'options'           => [ // the key will be stored in the db, the value will be shown as label;
					1 => "Establishment",
					2 => "House"
				],
				// optional
				'inline'            => true, // show the radios all on the same line?
			]
		);

		$this->crud->scripts = "
		var map;
		function toggleRadio() {
			var non_house = ['establishment_div', 'add_venue'];
			var non_house_display = 'none';
			var house_display = 'none';
			if (document.getElementById('venuetype_1').checked) {
				non_house_display = 'block';
			} else if(document.getElementById('venuetype_2').checked) {
				house_display = 'block';
			}
			for (i = 0; i < non_house.length; i++) {
				document.getElementById(non_house[i]).style.display = non_house_display;
		    }
		    $('.house').css('display', house_display);
		    if (typeof google !== 'undefined') {
                google.maps.event.trigger(map, 'resize');
            }
		}
		toggleRadio();
		$(function(){
		    var start = $('#start');

    start.on('change', function(){ //bind() for older jquery version
			$('[name=fake_finish]').timepicker('setMinTime', new Date($(this).val()));
    }); //could be change() or trigger('change')
    
		});
		";

		$this->crud->addField(
			[
				'name'  => 'name',
				'label' => 'Name',
				'type'  => 'text'
			]
		);

		$this->crud->addField(
			[  // Select2
				'label'     => "Artist",
				'type'      => 'select2',
				'name'      => 'artist_id', // the db column for the foreign key
				'entity'    => 'artists', // the method that defines the relationship in your Model
				'attribute' => 'name', // foreign key attribute that is shown to user
				'model'     => "App\Models\Artist" // foreign key model
			]);

		$this->crud->addField(
			[  // Select2
				'wrapperAttributes'  => ['id' => 'establishment_div'],
				'label'              => "Venue",
				'placeholder'        => "Start typing to select a venue",
				'hint'               => "Choose the Add Venue option if you don't see the venue",
				'type'               => 'select2_ajax',
				'name'               => 'venue_id', // the db column for the foreign key
				'entity'             => 'venue', // the method that defines the relationship in your Model
				'attribute'          => 'name', // foreign key attribute that is shown to user
				'model'              => "App\Models\Venue", // foreign key model
				'datasource'         => url("search/venues/name"), // url to controller search function (with /{id} should return model)
				'minimumInputLength' => 2
			]);

		$this->crud->addField(
			[
				'wrapperAttributes' => ['id' => 'add_venue'],
				'type'              => 'custom_html',
				'name'              => 'add_venue',
				'value'             => '<a href="/admin/venue/create">Add Venue</a>'
			]);

		// ------ CRUD FIELDS
		$this->crud->addField([
			'wrapperAttributes' => ['class' => 'house form-group col-md-12'],
			'name'              => 'house',
			'label'             => 'Address',
			'type'              => 'google_address',
			'google_api_key'    => env('GOOGLE_MAP_JS_API_KEY'),
			'current'           => false,
			'components'        => [
				'name'          => [
					'name'     => 'name',
					'label'    => 'Name',
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

		// ------ CRUD FIELDS
		$this->crud->addField([
			'wrapperAttributes' => ['class' => 'house form-group col-md-12'],
			'name'              => 'facebook',
			'label'             => 'Facebook'
		]);

		$this->crud->addField(
			[
				'label' => "Start",
				'type'  => 'datetime_picker',
				'name'  => 'start'
			]);

		$this->crud->addField(
			[
				'label' => "Finish",
				'type'  => 'duration_picker',
				'name'  => 'finish',
				'start' => 'start'
			]);

		$this->crud->addField(
			[
				'label' => "Poster",
				'type'  => 'image_blob',
				'name'  => 'poster',
				'crop'  => true
			]);

		$this->crud->addField(
			[
				'label'     => "Age",
				'type'      => 'select',
				'name'      => 'age', // the db column for the foreign key
				'entity'    => 'age', // the method that defines the relationship in your Model
				'attribute' => 'value', // foreign key attribute that is shown to user
				'model'     => "App\Models\Age" // foreign key model
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
		// $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
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
		// $this->crud->allowAccess('revisions');

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
