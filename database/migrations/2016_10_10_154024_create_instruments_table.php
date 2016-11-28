<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInstrumentsTable extends Migration
{

	public function up()
	{
		Schema::create('instruments', function (Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('instruments');
	}
}