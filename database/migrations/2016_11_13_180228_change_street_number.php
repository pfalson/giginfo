<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStreetNumber extends Migration
{
	const tableName = 'addresses';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table(static::tableName, function(Blueprint $table)
	    {
		    $table->string('street_number', 30)->nullable()->change();
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table(static::tableName, function(Blueprint $table)
	    {
		    $table->string('street_number', 255)->change();
	    });
    }
}
