<?php
use App\Models\Address;
use App\Models\Artist;
use App\Models\City;
use App\Models\DropDowns;
use App\Models\Gig;
use App\Models\State;
use App\Models\Street;
use App\Models\Venue;
use App\Models\VenueType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: pfalson
 * Date: 10/18/2016
 * Time: 6:34 AM
 */
class GigSeeder extends Seeder
{
	public function run()
	{
//		DB::listen(function ($query)
//		{
//			var_dump($query->sql);
//			var_dump($query->bindings);
//		});

		$age = DropDowns::firstOrCreate(
			[
				'name' => 'age',
				'code' => $Age_Limit,
				'value' => $Age_Limit
			]
		);

		$establishment = VenueType::firstOrCreate(
			[
				'name' => 'Establishment'
			]
		);

		$house = VenueType::firstOrCreate(
			[
				'name' => 'House'
			]
		);

		$import = file(__DIR__ . '/../../resources/imports/GlassofHearts-Standard.csv');
			for ($i = 0; $i < count($import); ++$i)
			{
				$item = $import[$i];
//				var_dump($item);
				$values = str_getcsv($item);
				$c = 0;
				$ArtistName = $values[$c++];
				$Date = $values[$c++];
				$Time = $values[$c++];
				$ShowName = $values[$c++];
				$Doors_Time = $values[$c++];
				$City = $values[$c++];
				$State = $values[$c++];
				$StateAbbr = $values[$c++];
				$Country = $values[$c++];
				$Venue_Name = $values[$c++];
				$Venue_Address = $values[$c++];
				$Venue_URL = $values[$c++];
				$Venue_ZIP = $values[$c++];
				$Venue_Phone = $values[$c++];
				$Age_Limit = $values[$c++];
				$Ticket_Price = $values[$c++];
				$Ticket_URL = $values[$c++];
				$Description = $values[$c++];
				$Other_Artist_1 = $values[$c++];
				$Other_Artist_1_Time = $values[$c++];
				$Other_Artist_1_URL = $values[$c++];
				$Other_Artist_1_SetType = $values[$c++];
				$Other_Artist_2 = $values[$c++];
				$Other_Artist_2_Time = $values[$c++];
				$Other_Artist_2_URL = $values[$c++];
				$Other_Artist_2_SetType = $values[$c++];
				$Other_Artist_3 = $values[$c++];
				$Other_Artist_3_Time = $values[$c++];
				$Other_Artist_3_URL = $values[$c++];
				$Other_Artist_3_SetType = $values[$c++];
				$artist = Artist::firstOrCreate(
					[
						'name' => $ArtistName,
						'website' => str_replace(' ', '', $ArtistName) . '.com',
						'facebook' => str_replace(' ', '', $ArtistName)
					]
				);
				$google_address = $this->geocode($Venue_Address . ' ' . $City . ' ' . $State . ' ' . $Venue_ZIP);
				$long = $google_address[0];
				$lat = $google_address[1];
				$address = explode(',', $google_address[2]);
				while (count($address) > 4)
				{
					$street = array_shift($address);
				}
				$street = explode(' ', trim($address[0]));
				$street_number = array_shift($street);
				$street_name = implode(' ', $street);
				$zip = explode(' ', trim($address[2]));
				$abbr = array_shift($zip);

				$street = Street::firstOrCreate(
					[
						'name' => $street_name
					]
				);

				$state = State::where('abbr', $abbr)->pluck('id')->first();

				$city = City::where(
					[
						'name' => trim($address[1]),
						'state_id' => $state
					])->first();

				$address = Address::firstOrCreate(
					[
						'street_number' => $street_number,
						'street_id' => $street->id,
						'city_id' => $city->id
					]
				);

				$venue = Venue::firstOrCreate(
					[
						'name' => $Venue_Name,
						'website' => $Venue_URL,
						'address_id' => $address->id,
						'phone' => $Venue_Phone,
						'venuetype_id' => $establishment->id
					]
				);

				$start = Carbon::parse($Date . ' ' . $Time);
				$finish = $start->addHours(2);

				$gig = Gig::firstOrCreate(
					[
						'artist_id' => $artist->id,
						'venue_id' => $venue->id,
						'name' => $ShowName,
						'start' => $start,
						'finish' => $finish,
						'description' => $Description,
						'price' => $Ticket_Price,
						'age' => $age->id,
						'ticketurl' => $Ticket_URL
					]
				);
			}
	}

	// function to geocode address, it will return false if unable to geocode address
	function geocode($address)
	{

		// url encode the address
		$address = urlencode($address);

		// google map geocode api url
		$url = "http://maps.google.com/maps/api/geocode/json?address={$address}";

		// get the json response
		$resp_json = file_get_contents($url);

		// decode the json
		$resp = json_decode($resp_json, true);

		// response status will be 'OK', if able to geocode given address
		if ($resp['status'] == 'OK')
		{

			// get the important data
			$lati = $resp['results'][0]['geometry']['location']['lat'];
			$longi = $resp['results'][0]['geometry']['location']['lng'];
			$formatted_address = $resp['results'][0]['formatted_address'];

			// verify if data is complete
			if ($lati && $longi && $formatted_address)
			{

				// put the data in the array
				$data_arr = array();

				array_push(
					$data_arr,
					$lati,
					$longi,
					$formatted_address
				);

				return $data_arr;

			}
			else
			{
				return false;
			}

		}
		else
		{
			return false;
		}
	}
}