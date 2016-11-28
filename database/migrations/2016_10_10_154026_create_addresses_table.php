<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressesTable extends Migration {

	public function up()
	{
		Schema::create('addresses', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('street1');
			$table->string('street2');
			$table->integer('city_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('addresses');
	}
}