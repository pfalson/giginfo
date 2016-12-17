<?php

namespace App\Http\Controllers\Admin;

use App\Models\Address;
use App\Models\City;
use App\Models\Country;
use App\Models\LocationType;
use App\Models\PostalCode;
use App\Models\PostCodeType;
use App\Models\State;
use App\Models\Street;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\AddressRequest as StoreRequest;
use App\Http\Requests\AddressRequest as UpdateRequest;
use Exception;
use Request;

class AddressCrudController extends CrudController
{

	public function setUp()
	{

		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->crud->setModel("App\Models\Address");
		$this->crud->setRoute("admin/address");
		$this->crud->setEntityNameStrings('address', 'addresses');

		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

		$this->crud->setFromDb();

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
		return parent::storeCrud();
	}

	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}

	/**
	 * @param [] $params
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public static function matchAddress($params)
	{
		$address = null;

		if (isset($params['street'])
			&& isset($params['postal_code'])
			&& isset($params['longitude'])
			&& isset($params['latitude'])
			&& isset($params['city'])
			&& isset($params['state'])
			&& isset($params['sortname'])
		)
		{
			$country = Country::where(['sortname' => $params['sortname']])->first();
			if ($country)
			{
				$args = ['country_id' => $country->id];
				foreach (['states.name' => 'state', 'abbr' => 'abbr'] as $key => $item)
				{
					if (!empty($params[$item]))
					{
						$args[$key] = $params[$item];
						break;
					}
				}

				$state = State::where($args)->first();
				if ($state == null && count($args) === 3)
				{
					$state = State::create($args);
				}
				if ($state)
				{
					$args = ['cities.name' => $params['city'], 'state_id' => $state->id];
					$city = City::where($args)->firstOrCreate($args);
					if ($city)
					{
						$locationtype_id = LocationType::where('name', 'Primary')->pluck('id')->first();
						$postcodetype_id = PostCodeType::where('name', 'Standard')->pluck('id')->first();
						$args = [
							'code'            => $params['postal_code'],
							'city_id'         => $city->id,
							'locationtype_id' => $locationtype_id,
							'postcodetype_id' => $postcodetype_id
						];

						$postalcode = PostalCode::where($args)->firstOrCreate($args);

						$args = ['name' => $params['street']];
						$street = Street::where($args)->firstOrCreate($args);
						$args = [
							'street_id'     => $street->id,
							'postalcode_id' => $postalcode->id
						];

						if (isset($params['street_number']))
						{
							$args['street_number'] = $params['street_number'];
						}

						$address = Address::where($args)->first();

						$args['longitude'] = $params['longitude'];
						$args['latitude'] = $params['latitude'];

						if ($address)
						{
							$address->fill($args);
							$address->save();
						}
						else
						{
							$address = Address::where($args)->firstOrCreate($args);
						}
					}
				}
			}
		}

		return $address;
	}

	/**
	 * @param Request $request
	 * @return PostalCode
	 */
	public static function getLocation($request)
	{
		$path = $request->getPathInfo();

		$city = $lat = $long = 0;

		$postalcode = null;

		try
		{
			$geoplugin = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $request->ip()));

			if (is_numeric($geoplugin['geoplugin_latitude']) && is_numeric($geoplugin['geoplugin_longitude']))
			{
				$lat = $geoplugin['geoplugin_latitude'];
				$long = $geoplugin['geoplugin_longitude'];
				$cityName = $geoplugin['geoplugin_city'];
				$region = $geoplugin['geoplugin_region'];
				$countryCode = $geoplugin['geoplugin_countryCode'];
				$countryName = $geoplugin['geoplugin_countryName'];
				$country = Country::whereName($countryName)->orWhere('sortname', 'like', $countryCode . '%')->first();

				if ($country != null)
				{
					$state = State::whereCountryId($country->id)->where('abbr', $region)->first();

					if ($state != null)
					{
						$city = City::whereStateId($state->id)->where('cities.name', $cityName)->first();

						if ($city != null)
						{
							$postalcode = PostalCode::whereCityId($city->id)->first();
						}
					}
				}

				if (!$postalcode)
				{
					$latitude = number_format(floor($lat * 100) / 100, 2, '.', '');
					$longitude = number_format(floor($long * 100) / 100, 2, '.', '');
					$postalcode = PostalCode::whereLatitude($latitude)->whereLongitude($longitude)->first();
				}
			}
		} catch (Exception $ex)
		{
		}


		if (!$postalcode)
		{
			$postalcode = new PostalCode();
			if ($city)
			{
				$postalcode->city_id = $city->id;
			}
		}

		$postalcode->longitude = $long;
		$postalcode->latitude = $lat;

		return $postalcode;
	}
}
