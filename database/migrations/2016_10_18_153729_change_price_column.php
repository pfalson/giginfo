<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangePriceColumn extends Migration
{
	const table = 'gigs';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(static::table, function(Blueprint $table)
        {
        	$table->string('price', 10)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table(static::table, function(Blueprint $table)
	    {
		    $table->decimal('price', 10)->nullable()->change();
	    });
    }
}
