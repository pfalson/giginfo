<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMemberInstrumentsTable extends Migration
{

	public function up()
	{
		Schema::create('member_instruments', function (Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('member_id')->unsigned();
			$table->integer('instrument_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('member_instruments');
	}
}