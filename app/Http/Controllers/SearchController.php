<?php
/**
 * Created by PhpStorm.
 * User: pfalson
 * Date: 10/13/2016
 * Time: 11:18 AM
 */

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Response;

class SearchController extends Controller
{
	public function autocomplete($table, $column, $id = null)
	{
		if ($id !== null)
		{
			return Response::json(DB::table($table)->where(compact('id'))->get()->first());
		}

		$term = Input::get('q');

		$results = DB::table($table)
			->where($column, 'LIKE', '%' . $term . '%')
			->paginate();;

		return Response::json($results);
	}

	public function getRecord($id)
	{
		$city = \App\Models\City::findOrFail($id);
		return \Response::json($city);
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