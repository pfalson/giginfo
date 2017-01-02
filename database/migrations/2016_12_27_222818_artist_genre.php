<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArtistGenre extends Migration
{
	const tableName = 'artist_genre';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(static::tableName,  function (Blueprint $table)
		{
			$table->unsignedInteger('artist_id');
			$table->unsignedInteger('genre_id');
			$table->foreign('artist_id')->references('id')->on('artists')
				->onDelete('restrict')
				->onUpdate('restrict');
			$table->foreign('genre_id')->references('id')->on('dropdowns')
				->onDelete('restrict')
				->onUpdate('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop(static::tableName);
	}
}
