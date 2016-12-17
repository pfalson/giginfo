<?php
/**
 * Created by PhpStorm.
 * User: pfalson
 * Date: 10/13/2016
 * Time: 11:18 AM
 */

namespace App\Http\Controllers;

use App\Elegant;
use DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Response;

class SearchController extends Controller
{
	public function autocomplete($table, $column, $id = null)
	{
		/** @var Elegant|Builder $class */
		$builder = null;

		$className = 'App\\Models\\' . $table;

		if (class_exists($className))
		{
			$builder = new $className;
			$table = $builder->getTable();
		}
		else
		{
			$builder = DB::table($table);
		}

		if ($id != null)
		{
			$column = $table . '.id';
		}
		else
		{
			$column = $table . '.' . $column;
		}

		if ($id !== null)
		{
			return Response::json($builder->where($column, $id)->get()->first());
		}

		$term = Input::get('q');

		$results = $builder
			->where($column, 'LIKE', '%' . $term . '%')
			->orWhereRaw('replace(' . $column . ', "\'", "") LIKE "%' . trim($term, "'") . '%"')
//			->orWhereRaw('soundex(' . $column . ') LIKE "' . rtrim(soundex($term), '0') . '%"')
			->orderBy($column)
			->paginate();

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