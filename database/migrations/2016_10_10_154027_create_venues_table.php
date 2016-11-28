<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVenuesTable extends Migration {

	public function up()
	{
		Schema::create('venues', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name')->unique();
			$table->string('website')->unique();
			$table->string('facebook')->unique();
			$table->integer('address_id')->unsigned();
			$table->string('phone');
		});
	}

	public function down()
	{
		Schema::drop('venues');
	}
}