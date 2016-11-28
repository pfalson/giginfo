<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStatesTable extends Migration
{

	public function up()
	{
		Schema::table('states', function (Blueprint $table)
		{
			$table->increments('id')->change();
			$table->timestamps();
			$table->softDeletes();
			$table->unsignedInteger('country_id')->change();
		});
	}

	public function down()
	{
		Schema::table('states', function (Blueprint $table)
		{
			$table->dropColumn('created_at');
			$table->dropColumn('updated_at');
			$table->dropColumn('deleted_at');
		});
	}
}