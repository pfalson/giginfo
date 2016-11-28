<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVenueType extends Migration
{
	const tableName = 'venuetypes';
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

	    Schema::table('venues', function(Blueprint $table)
	    {
		    $table->unsignedInteger('venuetype_id');
		    $table->unique(['street_number', 'street_id', 'city_id']);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('venues', function(Blueprint $table)
	    {
		    $table->dropColumn('venuetype_id');
	    });

	    Schema::drop(static::tableName);
    }
}