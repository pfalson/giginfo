<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocationtypesTable extends Migration
{

	public function up()
	{
		Schema::create('locationtypes', function (Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('name')->unique();
		});
	}

	public function down()
	{
		Schema::drop('locationtypes');
	}
}