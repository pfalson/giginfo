<?php

use App\City;
use App\LocationType;
use App\PostalCode;
use App\PostalLocation;
use App\PostCodeType;
use App\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostalTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
//	    "Zipcode","ZipCodeType","City","State","LocationType","Lat","Long","Location","Decommisioned","TaxReturnsFiled","EstimatedPopulation","TotalWages"
//		"08889","STANDARD","WHITEHOUSE STATION","NJ","PRIMARY",40.60,-74.76,"NA-US-NJ-WHITEHOUSE STATION","false",4691,8570,401312434
		$csv = file(__DIR__ . '/../migrations/free-zipcode-database-Primary.csv');
		$usa_id = 231;
		$trancount = 0;

		try
		{
			Cache::flush();
		} catch (Exception $e)
		{
		}

		DB::table('postalcodes')->truncate();
		DB::table('cities')->whereNotNull('created_at')->delete();
		DB::table('states')->whereNotNull('created_at')->delete();

		$states_abbr = array_flip(
			array(
				'AL'=>'ALABAMA',
				'AK'=>'ALASKA',
				'AS'=>'AMERICAN SAMOA',
				'AZ'=>'ARIZONA',
				'AR'=>'ARKANSAS',
				'CA'=>'CALIFORNIA',
				'CO'=>'COLORADO',
				'CT'=>'CONNECTICUT',
				'DE'=>'DELAWARE',
				'DC'=>'DISTRICT OF COLUMBIA',
				'FM'=>'FEDERATED STATES OF MICRONESIA',
				'FL'=>'FLORIDA',
				'GA'=>'GEORGIA',
				'GU'=>'GUAM',
				'HI'=>'HAWAII',
				'ID'=>'IDAHO',
				'IL'=>'ILLINOIS',
				'IN'=>'INDIANA',
				'IA'=>'IOWA',
				'KS'=>'KANSAS',
				'KY'=>'KENTUCKY',
				'LA'=>'LOUISIANA',
				'ME'=>'MAINE',
				'MH'=>'MARSHALL ISLANDS',
				'MD'=>'MARYLAND',
				'MA'=>'MASSACHUSETTS',
				'MI'=>'MICHIGAN',
				'MN'=>'MINNESOTA',
				'MS'=>'MISSISSIPPI',
				'MO'=>'MISSOURI',
				'MT'=>'MONTANA',
				'NE'=>'NEBRASKA',
				'NV'=>'NEVADA',
				'NH'=>'NEW HAMPSHIRE',
				'NJ'=>'NEW JERSEY',
				'NM'=>'NEW MEXICO',
				'NY'=>'NEW YORK',
				'NC'=>'NORTH CAROLINA',
				'ND'=>'NORTH DAKOTA',
				'MP'=>'NORTHERN MARIANA ISLANDS',
				'OH'=>'OHIO',
				'OK'=>'OKLAHOMA',
				'OR'=>'OREGON',
				'PW'=>'PALAU',
				'PA'=>'PENNSYLVANIA',
				'PR'=>'PUERTO RICO',
				'RI'=>'RHODE ISLAND',
				'SC'=>'SOUTH CAROLINA',
				'SD'=>'SOUTH DAKOTA',
				'TN'=>'TENNESSEE',
				'TX'=>'TEXAS',
				'UT'=>'UTAH',
				'VT'=>'VERMONT',
				'VI'=>'VIRGIN ISLANDS',
				'VA'=>'VIRGINIA',
				'WA'=>'WASHINGTON',
				'WV'=>'WEST VIRGINIA',
				'WI'=>'WISCONSIN',
				'WY'=>'WYOMING',
				'AE'=>'ARMED FORCES AFRICA \ CANADA \ EUROPE \ MIDDLE EAST',
				'AA'=>'ARMED FORCES AMERICAS',
				'AP'=>'ARMED FORCES PACIFIC'
			)
		);
		foreach ($states_abbr as $desc => $abbr)
		{
			$state = Str::title($desc);
			State::where('name', $state)->update(['abbr' => $abbr]);
		}

		State::firstOrCreate(['abbr' => 'AA', 'name' => 'Armed Forces Americas', 'country_id' => 231]);
		State::firstOrCreate(['abbr' => 'AE', 'name' => 'Armed Forces', 'country_id' => 231]);
//		State::firstOrCreate(['abbr' => 'AP', 'name' => 'Armed Forces Pacific', 'country_id' => 231]);
		State::firstOrCreate(['abbr' => 'AS', 'name' => 'American Samoa', 'country_id' => 231]);
		State::firstOrCreate(['abbr' => 'DC', 'name' => 'District of Columbia', 'country_id' => 231]);
		State::firstOrCreate(['abbr' => 'FM', 'name' => 'Federated States of Micronesia', 'country_id' => 231]);
		State::firstOrCreate(['abbr' => 'GU', 'name' => 'Guam', 'country_id' => 231]);
		State::firstOrCreate(['abbr' => 'MH', 'name' => 'Marshall Islands', 'country_id' => 231]);
		State::firstOrCreate(['abbr' => 'MP', 'name' => 'Northern Mariana Islands', 'country_id' => 231]);
		State::firstOrCreate(['abbr' => 'PW', 'name' => 'Palau', 'country_id' => 231]);
		State::firstOrCreate(['abbr' => 'PR', 'name' => 'Puerto Rico', 'country_id' => 231]);
		State::firstOrCreate(['abbr' => 'VI', 'name' => 'Virgin Islands', 'country_id' => 231]);

//		dd('here');
		DB::beginTransaction();

		foreach ($csv as $item)
		{
			$values = str_getcsv($item);
			$code = $values[0];
			$ztype = $values[1];
			$city = $values[2];
			$state = $values[3];
			$ltype = $values[4];
			$lat = $values[5];
			$long = $values[6];
			$location = $values[7];
//			$decomissioned = $values[8] !== 'false';

			$ztype_id = Cache::remember('pct_' . $ztype, 5, function () use ($ztype)
			{
				$id = PostCodeType::whereRaw('lower(`name`) = ?', [strtolower($ztype)])->pluck('id')->first();
				if (empty($id))
				{
					$id = PostCodeType::firstOrCreate(['name' => Str::title($ztype)])['id'];
				}

				return $id;
			});

			$state_id = Cache::remember('state_' . $state, 5, function () use ($state, $usa_id)
			{
				$id = State::where(['abbr' => $state, 'country_id' => $usa_id])->pluck('id')->first();
				if (empty($id))
				{
					$id = State::firstOrCreate(
						[
							'name' => Str::title($state),
							'country_id' => $usa_id
						])['id'];
				}

				return $id;
			});

			$city_id = Cache::remember('city_' . $city, 5, function () use ($city, $state_id)
			{
				$id = City::whereRaw('lower(`name`) = ? and state_id = ?', [strtolower($city), $state_id])->pluck('id')->first();
				if (empty($id))
				{
					$id = City::firstOrCreate(
						[
							'name' => Str::title($city),
							'state_id' => $state_id
						])['id'];
				}

				return $id;
			});

			$ltype_id = Cache::remember('ltype_' . $ltype, 5, function () use ($ltype)
			{
				$id = LocationType::whereRaw('lower(`name`) = ?', [strtolower($ltype)])->pluck('id')->first();
				if (empty($id))
				{
					$id = LocationType::firstOrCreate(['name' => Str::title($ltype)])['id'];
				}

				return $id;
			});

			$location_id = Cache::remember('location_' . $location, 5, function () use ($location)
			{
				$id = PostalLocation::whereRaw('lower(`name`) = ?', [strtolower($location)])->pluck('id')->first();
				if (empty($id))
				{
					$id = PostalLocation::firstOrCreate(['name' => Str::title($location)])['id'];
				}

				return $id;
			});

			$attributes = [
				'code' => $code,
				'city_id' => $city_id,
				'postallocation_id' => $location_id,
				'longtitude' => $long,
				'latitude' => $lat,
				'locationtype_id' => $ltype_id,
				'postcodetype_id' => $ztype_id
			];

//			dd($attributes);
			$result = PostalCode::insert($attributes);
//dd($result);
//			if ($city_id == 47042)
//			{
//				var_dump($values);
//				dd($result);
//			}

			++$trancount;

			if ($trancount === 1000)
			{
				DB::commit();
				DB::beginTransaction();
				$trancount = 0;
			}
		}

		DB::commit();
	}
}
