<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostallocationsTable extends Migration {

	public function up()
	{
		Schema::create('postallocations', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('name')->unique();
		});
	}

	public function down()
	{
		Schema::drop('postallocations');
	}
}