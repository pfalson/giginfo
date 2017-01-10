<?php

namespace App\Http\Controllers;

use App\Models\TemplateType;
use Flash;
use Request;
use Response;
use View;

class TemplateTypeController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return View
	 */
	public function index()
	{
		$dropdowns = TemplateType::all();

		return view('dropdowns.index')
			->with(['tableName' => 'TemplateTypes', 'table' => 'templatetype', 'dropdowns' => $dropdowns]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return View
	 */
	public function create()
	{
		return view('dropdowns.create')
			->with(['tableName' => 'TemplateTypes', 'table' => 'templatetype']);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Request::all();

		TemplateType::create($input);

		Flash::success('TemplateType saved successfully.');

		return redirect(route('templatetype.index'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return View
	 */
	public function show($id)
	{
		return view('dropdowns.show')
			->with(['tableName' => 'TemplateTypes', 'table' => 'templatetype']);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return View
	 */
	public function edit($id)
	{
		return view('dropdowns.edit')
			->with(['tableName' => 'TemplateTypes', 'table' => 'templatetype']);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function update($id)
	{
		$templateType = TemplateType::where(compact('id'))->first();

		if (empty($templateType))
		{
			Flash::error('Template Type not found');
		}
		else
		{
			$templateType->update(Request::all(), $id);


			Flash::success('TemplateType saved successfully.');
		}

		return redirect(route('templatetype.index'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return null;
	}

}

?>