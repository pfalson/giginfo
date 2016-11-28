<?php

use Illuminate\Database\Migrations\Migration;

class RenameGigTable extends Migration
{
	const table = 'gig';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename(static::table, static::table . 's');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::rename(static::table . 's', static::table);
    }
}
