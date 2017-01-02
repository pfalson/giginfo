<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameLongitude extends Migration
{
	const tableName = 'postalcodes';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table(static::tableName, function(Blueprint $table)
	    {
		    $table->renameColumn('longtitude', 'longitude');
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
		    $table->renameColumn('longitude', 'longtitude');
	    });
    }
}
