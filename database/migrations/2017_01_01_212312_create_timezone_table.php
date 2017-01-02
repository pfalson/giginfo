<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimezoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('timezones', function (Blueprint $table)
	    {
		    $table->increments('id');
		    $table->timestamps();
		    $table->softDeletes();
		    $table->string('name');
		    $table->string('zone');
		    $table->integer('offset');
		    $table->unique(['name', 'zone']);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::drop('timezones');
    }
}
