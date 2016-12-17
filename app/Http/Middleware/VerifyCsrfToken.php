<?php

namespace App\Http\Middleware;

use App\Exceptions\Handler;
use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Session\TokenMismatchException;
use Redirect;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

	public function handle($request, Closure $next)
	{
		$regex = '#' . implode('|', $this->except) . '#';

		if (preg_match($regex, $request->path()) ||
			$this->isReading($request) ||
			$this->runningUnitTests() ||
			$this->shouldPassThrough($request) ||
			$this->tokensMatch($request))
		{
//			Logging::var_trace(['request->path', $request->path()]);

//			ErrorProvider::showErrors();

			return $this->addCookieToResponse($request, $next($request));
		}

		if (!array_key_exists('laravel_session', $_COOKIE) || !array_key_exists('XSRF-TOKEN', $_COOKIE))
		{
			return Redirect::away($request->server('HTTP_REFERER'))->withErrors(['form' => Handler::cookiesRemoved]);
		}
		else
		{
//			Logging::errorlog('Failed to addCookieToResponse');
//			Logging::errorlog('sessionToken = ' . $request->session()->token());
//			Logging::error_var_trace(compact('request'), true, 3);

			throw new TokenMismatchException;
		}
	}
}
