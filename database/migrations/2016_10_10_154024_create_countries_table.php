<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountriesTable extends Migration
{

	public function up()
	{
		Schema::table('countries', function (Blueprint $table)
		{
			$table->increments('id')->change();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::table('countries', function (Blueprint $table)
		{
			$table->dropColumn('created_at');
			$table->dropColumn('updated_at');
			$table->dropColumn('deleted_at');
		});
	}
}