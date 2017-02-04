<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class SystemAdmin
{
	/** @noinspection PhpUnusedParameterInspection */
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @param  string|null $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		/** @var User $user */
		/** @noinspection PhpUndefinedMethodInspection */
		$user = Auth::user();

		if ($user === null || $user->name != 'Peter Falson')
		{
			return redirect('/home');
		}

		return $next($request);
	}
}
