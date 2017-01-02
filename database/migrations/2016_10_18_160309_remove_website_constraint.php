<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveWebsiteConstraint extends Migration
{
	const table = 'venues';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table(static::table, function(Blueprint $table)
	    {
		    $table->dropUnique('venues_website_unique');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//	    Schema::table(static::table, function(Blueprint $table)
//	    {
//		    $table->string('website')->nullable()->unique()->change();
//	    });
    }
}
