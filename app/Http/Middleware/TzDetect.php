<?php
/**
 * Created by PhpStorm.
 * User: pfalson
 * Date: 12/31/2016
 * Time: 2:07 PM
 */

namespace App\Http\Middleware;


use Closure;
use Request;
use Session;

class TzDetect
{
	public function handle($request, Closure $next)
	{
		if (!ends_with(\URL::current(), 'detect') && !Session::has('tz_done'))
		{
			Session::put('tz_route', Request::getRequestUri());
			return redirect('tzdetect');
		}
		return $next($request);
	}
}