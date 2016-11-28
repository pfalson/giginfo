<?php

namespace App\Http\Controllers\Crud;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Venue;
use Log;

class VenueController extends Controller
{
	public $modelMap = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"created_at","Type":"timestamp","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"updated_at","Type":"timestamp","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"name","Type":"varchar(255)","Null":"NO","Key":"UNI","Default":null,"Extra":""},{"Field":"website","Type":"varchar(255)","Null":"NO","Key":"UNI","Default":null,"Extra":""},{"Field":"facebook","Type":"varchar(255)","Null":"NO","Key":"UNI","Default":null,"Extra":""},{"Field":"address_id","Type":"int(10) unsigned","Null":"NO","Key":"MUL","Default":null,"Extra":""},{"Field":"phone","Type":"varchar(255)","Null":"NO","Key":"","Default":null,"Extra":""}]';

	public $fillable = '["name","website","facebook","phone"]';

    public function manageCrud()
    {
        return view('manage-venues', ['modelMap' => json_decode($this->modelMap), 'fillable' => json_decode($this->fillable)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Venue::latest()->paginate(env('CRUD.PAGINATE'));

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

        $create = Venue::create($request->all());
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

        $edit = Venue::find($id)->update($request->all());

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
        Venue::find($id)->delete();
        return response()->json(['done']);
    }
}