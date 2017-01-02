<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeGigUniqueness extends Migration
{
	const tableName = 'gigs';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table(static::tableName, function(Blueprint $table)
		{
			$table->foreign('artist_id')->references('id')->on('artists')
				->onDelete('restrict')
				->onUpdate('restrict');
			$table->foreign('venue_id')->references('id')->on('venues')
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
		Schema::table(static::tableName, function(Blueprint $table)
		{
			$table->dropForeign('gigs_venue_id_foreign');
			$table->dropForeign('gigs_artist_id_foreign');
		});
	}
}
