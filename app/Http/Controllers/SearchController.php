<?php
/**
 * Created by PhpStorm.
 * User: pfalson
 * Date: 10/13/2016
 * Time: 11:18 AM
 */

namespace App\Http\Controllers;


use App\City;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Response;

class SearchController extends Controller
{
	public function autocomplete()
	{
		$term = Input::get('term');

		$results = array();

		$queries = DB::table('cities')
			->where('name', 'LIKE', '%' . $term . '%')
			->take(25)->get();

		foreach ($queries as $query)
		{
			$results[] = ['id' => $query->id, 'value' => $query->name];
		}
		return Response::json($results);
	}

	public function find(Request $request, $table)
	{
		$params = $request->query->all();
		$where = [];
		foreach ($params as $column => $value)
		{
			if (strstr($value, '%') !== false)
			{
				$op = 'like';
			}
			else
			{
				$op = '=';
			}
			$where[] = [$column, $op, $value];
		}
		return DB::table($table)->where($where)->get();
	}
}