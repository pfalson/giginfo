<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistMemberRoles extends Migration
{
	const tableName = 'artist_member_roles';

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
			$table->integer('role_id')->unsigned();
		});

		Schema::table(static::tableName, function (Blueprint $table)
		{
			$table->unique(['artist_id', 'member_id', 'role_id']);
		});

		Schema::table('artist_members', function (Blueprint $table)
		{
			$table->unique(['artist_id', 'member_id']);
		});
	}

	public function down()
	{
		Schema::drop(static::tableName);
	}
}
