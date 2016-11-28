<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostalcodesTable extends Migration
{

	public function up()
	{
		Schema::create('postalcodes', function (Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('code');
			$table->unsignedInteger('city_id');
			$table->unsignedInteger('postallocation_id')->nullable();
			$table->string('longitude');
			$table->string('latitude');
			$table->unsignedInteger('locationtype_id')->nullable();
			$table->unsignedInteger('postcodetype_id')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('postalcodes');
	}
}