<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGenresTable extends Migration
{

	public function up()
	{
		Schema::create('genres', function (Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('name')->unique();
		});
	}

	public function down()
	{
		Schema::drop('genres');
	}
}