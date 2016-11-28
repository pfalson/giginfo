<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArtistsTable extends Migration
{

	public function up()
	{
		Schema::create('artists', function (Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->string('name')->unique();
			$table->string('website')->unique();
			$table->string('facebook')->unique();
		});
	}

	public function down()
	{
		Schema::drop('artists');
	}
}