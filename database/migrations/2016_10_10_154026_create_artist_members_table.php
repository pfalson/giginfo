<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArtistMembersTable extends Migration
{

	public function up()
	{
		Schema::create('artist_members', function (Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('artist_id')->unsigned();
			$table->integer('member_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('artist_members');
	}
}