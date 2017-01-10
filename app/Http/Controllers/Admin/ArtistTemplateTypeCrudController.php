<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserArtist;
use Auth;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ArtistTemplateTypeRequest as StoreRequest;
use App\Http\Requests\ArtistTemplateTypeRequest as UpdateRequest;

class ArtistTemplateTypeCrudController extends CrudController
{

	public function setUp()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->crud->setModel("App\Models\ArtistTemplateType");
		$this->crud->setRoute("admin/artist_template_type");
		$this->crud->setEntityNameStrings('Template Type', 'Template Types');

		$addArtist = true;
		$user = Auth::user();
		if ($user !== null)
		{
			$addArtist = UserArtist::count() > 1;
		}

		if ($addArtist)
		{
			$this->crud->addColumn(
				[
					'name'  => 'artistName',
					'label' => 'Artist',
				]
			);
		}

		$this->crud->addColumn(
			[
				'name'      => 'templateName',
				'label'     => 'Type',
			]
		);

		$this->crud->addColumn(
			[
				'name'      => 'artistTemplateName',
				'label'     => 'Template',
			]
		);

		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

		$hasArtists = UserArtist::count() > 0;

		if ($hasArtists)
		{
			$this->crud->addField(
				[  // Select2
					'label'     => "Artist",
					'type'      => 'select',
					'name'      => 'artist_id', // the db column for the foreign key
					'entity'    => 'artists', // the method that defines the relationship in your Model
					'attribute' => 'name', // foreign key attribute that is shown to user
					'model'     => "App\Models\UserArtist" // foreign key model
				]);

			$this->crud->addField(
				[
					'label'     => "Type",
					'type'      => 'select',
					'name'      => 'templatetype_id', // the db column for the foreign key
					'entity'    => 'templatetype', // the method that defines the relationship in your Model
					'attribute' => 'value', // foreign key attribute that is shown to user
					'model'     => "App\Models\TemplateType" // foreign key model
				]);

			$this->crud->addField(
				[  // Select2
					'label'     => "Template",
					'type'      => 'select',
					'name'      => 'artist_template_id', // the db column for the foreign key
					'entity'    => 'artisttemplate', // the method that defines the relationship in your Model
					'attribute' => 'name', // foreign key attribute that is shown to user
					'model'     => "App\Models\ArtistTemplate" // foreign key model
				]);

		}
		else
		{
			$add_artist = '<p>Looks like you need to add an artist first</p>';
			$add_artist .= '<a href="/admin/artist/create">Add Artist</a>';

			$this->crud->addField(
				[
					'wrapperAttributes' => ['id' => 'add_artist'],
					'type'              => 'custom_html',
					'name'              => 'add_artist',
					'value'             => $add_artist
				]);
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

	public function showDetails($id)
	{
		$this->crud->addField(
			[
				'name' => 'artistName',
				'type' => 'text',
			]
		);
		$this->data['entry'] = $this->crud->getEntry($id);
		$this->data['entry']['poster'] = null;
		$this->data['crud'] = $this->crud;
		$this->data['fields'] = $this->crud->update_fields;
		foreach ($this->data['fields'] as &$field)
		{
			$field['attributes'] = ['readonly' => 'readonly'];
		}

		// load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
		return view('crud::details', $this->data);
	}
}
