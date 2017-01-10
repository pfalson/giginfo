<?php

namespace App\Http\Controllers;

use App\Models\ArtistTemplateType;
use App\Models\TemplateType;
use Blade;
use Exception;
use Illuminate\Http\Request;
use Response;

class IFrameController extends AppBaseController
{
	/**
	 * Display a listing of the Gig.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function gigs(Request $request)
	{
		return view('gigs.iframeGigs');
	}

	public function getBlade($args)
	{
		$code = \Request::get('type');

		try
		{
			$templatetype_id = TemplateType::where(compact('code'))->pluck('id')[0];
		} catch (Exception $e)
		{
			return $code ? "Invalid type '$code'" : "Missing 'type' parameter";
		}

		$artist_id = \Request::get('artist');
		try
		{
			$criteria = ['artist_template_types.artist_id' => $artist_id, 'templatetype_id' => $templatetype_id];
			$blade = ArtistTemplateType::where($criteria)->pluck('source')[0];
		} catch (Exception $e)
		{
			return 'No template found';
		}

		$php = Blade::compileString($blade);

		$compiled = $this->render($php, $args);
		return $compiled;
	}
}