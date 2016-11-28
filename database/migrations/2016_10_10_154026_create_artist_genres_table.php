<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArtistGenresTable extends Migration
{

	public function up()
	{
		Schema::create('artist_genres', function (Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('artist_id')->unsigned();
			$table->integer('genre_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('artist_genres');
	}
}