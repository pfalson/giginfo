<?php

namespace App\Http\Controllers\Crud;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gig;
use Log;

class GigController extends Controller
{
	public $modelMap = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"created_at","Type":"timestamp","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"updated_at","Type":"timestamp","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"artist_id","Type":"int(10) unsigned","Null":"NO","Key":"MUL","Default":null,"Extra":""},{"Field":"venue_id","Type":"int(10) unsigned","Null":"NO","Key":"MUL","Default":null,"Extra":""},{"Field":"start","Type":"datetime","Null":"NO","Key":"","Default":null,"Extra":""},{"Field":"finish","Type":"datetime","Null":"NO","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"poster","Type":"mediumblob","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"price","Type":"varchar(10)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"age","Type":"int(10) unsigned","Null":"NO","Key":"MUL","Default":null,"Extra":""},{"Field":"type","Type":"int(10) unsigned","Null":"YES","Key":"MUL","Default":null,"Extra":""},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"ticketurl","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]';

	public $fillable = '["artist_id","venue_id","name","start","finish","description","price","age","type","ticketurl","poster"]';

	public $columns = "['id']";

    public function manageCrud()
    {
        return view('manage-gigs', ['modelMap' => json_decode($this->modelMap), 'fillable' => json_decode($this->fillable)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Gig::latest()->paginate(env('CRUD.PAGINATE'));

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

        $create = Gig::create($request->all());
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

        $edit = Gig::find($id)->update($request->all());

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
        Gig::find($id)->delete();
        return response()->json(['done']);
    }
}