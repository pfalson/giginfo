<?php

use App\Models\Member;
use App\Models\VenueType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class JoinUsersToMembers extends Migration
{
	const tableName = 'members';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('users',  function (Blueprint $table)
	    {
		    $table->engine = 'InnoDB';
	    });

	    Schema::table(static::tableName,  function (Blueprint $table)
	    {
		    $table->engine = 'InnoDB';

		    $table->dropColumn('name');
		    $table->unsignedInteger('user_id')->unique()->after('deleted_at');
	    });

	    $user = \App\User::get()->first();

	    DB::table(static::tableName)->update(['user_id' => $user->id]);

	    Schema::table(static::tableName,  function (Blueprint $table)
	    {
		    $table->foreign('user_id')->references('id')->on('users')
			    ->onDelete('restrict')
			    ->onUpdate('restrict');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table(static::tableName,  function (Blueprint $table)
	    {
		    $table->dropForeign('members_user_id_foreign');
		    $table->dropColumn('user_id');
		    $table->string('name')->unique()->after('deleted_at');
	    });
    }
}
