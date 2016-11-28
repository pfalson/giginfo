<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGigTable extends Migration
{

	public function up()
	{
		Schema::create('gig', function (Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('artist_id')->unsigned();
			$table->integer('venue_id')->unsigned();
			$table->datetime('start');
			$table->datetime('finish');
			$table->string('description')->nullable();
			$table->binary('poster')->nullable();
			$table->decimal('price')->nullable();
			$table->integer('age')->unsigned();
			$table->integer('type')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('gig');
	}
}