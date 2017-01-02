<?php 

namespace App\Http\Controllers;

use App\Models\Genre;
use Flash;
use Request;

class GenreController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
	  $dropdowns = Genre::all();

	  return view('dropdowns.index')
		  ->with(['tableName' => 'Genres', 'table' => 'genre', 'dropdowns' => $dropdowns]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
	  return view('dropdowns.create')
		  ->with(['tableName' => 'Genres', 'table' => 'genre']);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
	  $input = Request::all();

	  Genre::create($input);

	  Flash::success('Genre saved successfully.');

	  return redirect(route('genre.index'));
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    
  }
  
}

?>