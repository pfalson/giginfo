<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitiesTable extends Migration
{

	public function up()
	{
		Schema::table('cities', function (Blueprint $table)
		{
			$table->increments('id')->change();
			$table->timestamps();
			$table->softDeletes();
			$table->unsignedInteger('state_id')->change();
//			$table->string('name');
		});
	}

	public function down()
	{
		Schema::table('cities', function (Blueprint $table)
		{
			$table->dropColumn('created_at');
			$table->dropColumn('updated_at');
			$table->dropColumn('deleted_at');
		});
	}
}