<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ArtistRequest as StoreRequest;
use App\Http\Requests\ArtistRequest as UpdateRequest;
use URL;

class ArtistCrudController extends CrudController
{

	public function setUp()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->crud->setModel("App\Models\Artist");
		$this->crud->setRoute("admin/artist");
		$this->crud->setEntityNameStrings('artist', 'artists');

		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

		$this->crud->setFromDb();
		$this->crud->removeColumn('city_id');
		$this->crud->addColumn('location');

		if (ends_with(URL::previous(), '/gig/create'))
		{
			$this->crud->addField(
				[
					'name'  => 'redirect_after_save',
					'label' => '',
					'value' => URL::previous(),
					'type'  => 'hidden'
				]);
		}

		$this->crud->addField([       // SelectMultiple = n-n relationship (with pivot table)
			'label'     => "Genres",
			'type'      => 'select2_multiple',
			'name'      => 'genres', // the method that defines the relationship in your Model
			'entity'    => 'genres', // the method that defines the relationship in your Model
			'attribute' => 'value', // foreign key attribute that is shown to user
			'model'     => "App\Models\Genre", // foreign key model
			'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
		]);

		$attributes = [  // Select2
			'label'              => "City",
			'placeholder'        => "Start typing to select a city",
			'hint'               => "Enter the city name only then scroll to find a match",
			'type'               => 'select2_ajax',
			'name'               => 'city_id', // the db column for the foreign key
			'entity'             => 'city', // the method that defines the relationship in your Model
			'attribute'          => 'full_location', // foreign key attribute that is shown to user
			'model'              => "App\Models\City", // foreign key model
			'datasource'         => url("search/City/name"), // url to controller search function (with /{id} should return model)
			'minimumInputLength' => 2
		];

		$path = $this->request->getPathInfo();

		$this->crud->addField($attributes);

		if (ends_with($path, '/edit'))
		{
			$feed = url('feed/gigs?artist=' . explode('/', $path)[3]);
			$this->crud->addField(
				[
					'name'              => 'rss',
					'label'             => 'RSS Feed Links',
					'type'              => 'heading',
					'wrapperAttributes' => ['style' => "margin: 0"]
				]
			);
			$this->crud->addField(
				[
					'name'       => 'currentEvent',
					'label'      => 'Upcoming Gigs',
					'type'       => 'text',
					'value'      => $feed . '&when=future',
					'attributes' => ['readonly' => 'readonly']
				]
			);

			$this->crud->addField(
				[
					'name'       => 'previousEvent',
					'label'      => 'Previous Gigs',
					'type'       => 'text',
					'value'      => $feed . '&when=past',
					'attributes' => ['readonly' => 'readonly']
				]
			);

			$this->crud->addField(
				[
					'name'       => 'eventPoster',
					'label'      => 'Poster Link',
					'type'       => 'text',
					'value'      => url('gigs/{id}/poster'),
					'attributes' => ['readonly' => 'readonly'],
					'hint'       => 'Substitute the gig "id" value for "{id}'
				]
			);
		}

		if (ends_with($path, '/create'))
		{
			$this->crud->addField(
				[
					'name'  => 'city_name',
					'label' => '',
					'type'  => 'hidden'
				]
			);

			$this->crud->addField(
				[
					'name'  => 'state_name',
					'label' => '',
					'type'  => 'hidden'
				]
			);

			$this->crud->addField(
				[
					'name'  => 'latitude',
					'label' => '',
					'type'  => 'hidden'
				]
			);

			$this->crud->addField(
				[
					'name'  => 'longitude',
					'label' => '',
					'type'  => 'hidden'
				]
			);

			$this->crud->addField(
				[
					'name'  => 'currentLocation',
					'label' => '',
					'type'  => 'hidden',
					'attributes' => ['id' => 'currentLocation']
				]
			);

			$this->crud->scripts = "
        </script>
        <script src='/js/getLocation.js'>
        </script>
        <script>
        var latitude = $('#latitude');

        geoFindMe(true);

        latitude.change(function () {
            if (latitude.val() !== '') {
                currentLocation = $('#currentLocation');
                if (currentLocation.val().indexOf('Unable') === 0) {
                    alert(currentLocation.val());
                }
                $('#form').submit();
            }
        });

        var city_name = $('input[name=city_name]');
        city_name.change(function () {
            if (city_name.val() !== '') {
                var city_id = $('input[name=city_id]');
                var state_name = $('input[name=state_name]');
                city_id.select2('data', {id: city_id.val(), text: city_name.val() + ', ' + state_name.val()}).trigger('change');
            }
        });
";
		}

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
		$this->crud->addClause('details');
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