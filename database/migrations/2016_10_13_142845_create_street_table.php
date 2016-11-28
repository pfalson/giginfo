<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStreetTable extends Migration
{
	const tableName = 'streets';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(static::tableName,  function (Blueprint $table)
        {
	        $table->engine = 'InnoDB';
	        $table->increments('id');
	        $table->timestamps();
	        $table->softDeletes();
	        $table->string('name')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(static::tableName);
    }
}
