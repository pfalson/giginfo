<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArtistMembersTable extends Migration
{
	const tableName = 'artist_members';

	public function up()
	{
		Schema::create(static::tableName, function (Blueprint $table)
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
		Schema::drop(static::tableName);
	}
}