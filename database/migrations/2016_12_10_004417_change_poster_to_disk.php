<?php

use App\Models\Gig;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePosterToDisk extends Migration
{
	const tableName = 'gigs';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$paths = [];
		foreach (Gig::get() as $gig)
		{
			if (empty($gig->poster))
				continue;

			$destination_path = 'uploads/artists/' . $gig->artist_id;

			$dir = public_path() . '/' . $destination_path;

			if (!File::exists($dir))
			{
				$result = File::makeDirectory($dir, 0777, true);
			}

			$output_file= $destination_path . '/' . md5(time().uniqid()).".jpg";

			$ifp = fopen(public_path() . '/' . $output_file, "wb");
			fwrite($ifp, $gig->poster);
			fclose($ifp);

			$paths[$gig->id] = $output_file;
		}

		Schema::table(static::tableName, function(Blueprint $table)
		{
			$table->dropColumn('poster');
		});

		Schema::table(static::tableName, function(Blueprint $table)
		{
			$table->string('poster')->nullable();
		});

		foreach ($paths as $id => $path)
		{
			DB::table('gigs')->where('id', $id)->update(['poster' => $path]);
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	}
}
