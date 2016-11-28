<?php
/**
 * Created by PhpStorm.
 * User: pfalson
 * Date: 10/13/2016
 * Time: 12:16 PM
 */

namespace App\Http\Controllers;

use App\City;
use Response;

class JsonController extends Controller
{
	public function getLocation($query)
	{
		$data = array();
		$results = City::search($query)
//			->where('name', 'LIKE',  '%' . $query . '%')
			->get();

		foreach ( $results as $result ):
			$data[] = $result->name;
		endforeach;

		return Response::json($data);
	}
}