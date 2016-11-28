<?php

namespace App\Http\Controllers\Crud;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use {{fullModelPath}};
use Log;

class {{ClassName}}Controller extends Controller
{
	public $modelMap = '{{modelMap}}';

	public $fillable = '{{fillableMap}}';

    public function manageCrud()
    {
        return view('manage-{{table_name}}', ['modelMap' => json_decode($this->modelMap), 'fillable' => json_decode($this->fillable)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = {{ClassName}}::latest()->paginate(env('CRUD.PAGINATE'));

        $response = [
            'pagination' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem()
            ],
            'data' => $items
        ];

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        ]);
		Log::error(print_r($request->all(),1));

        $create = {{ClassName}}::create($request->all());
		Log::error(print_r($create,1));

        return response()->json($create);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
        ]);

        $edit = {{ClassName}}::find($id)->update($request->all());

        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        {{ClassName}}::find($id)->delete();
        return response()->json(['done']);
    }
}