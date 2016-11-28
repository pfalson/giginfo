<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostcodetypesTable extends Migration {

	public function up()
	{
		Schema::create('postcodetypes', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('name')->unique();
		});
	}

	public function down()
	{
		Schema::drop('postcodetypes');
	}
}