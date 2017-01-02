<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GigNameNotRequired extends Migration
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
			$table->string('name')->nullable()->change();
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
			$table->string('name')->change();
		});
	}
}
