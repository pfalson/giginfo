<?php

namespace App\Exceptions;

use App;
use App\Mail\EmailError;
use Auth;
use Config;
use DOMDocument;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Jrean\UserVerification\Exceptions\UserNotVerifiedException;
use Log;
use Mail;

class Handler extends ExceptionHandler
{
	const sessionExpired = 'Sorry, your session seems to have expired. Please try again.';
	const cookiesRemoved = 'An error has occurred. If you recently cleared your cookies please try again';

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		\Illuminate\Auth\AuthenticationException::class,
		\Illuminate\Auth\Access\AuthorizationException::class,
		\Symfony\Component\HttpKernel\Exception\HttpException::class,
		\Illuminate\Database\Eloquent\ModelNotFoundException::class,
		\Illuminate\Session\TokenMismatchException::class,
		\Illuminate\Validation\ValidationException::class,
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception $exception
	 * @return void
	 */
	public function report(Exception $e)
	{
		// Don't report VerifyCSRFToken mismatch if the cookies were removed
		if ($this->notMissingToken($e))
		{
			if ($e instanceof AuthenticationException)
			{
			}
			else /** @noinspection PhpMethodParametersCountMismatchInspection */
				if ($e instanceof \Exception && !App::runningInConsole() && !App::environment('local'))
			{
				$debugSetting = Config::get('app.debug');

				Config::set('app.debug', true);
				if (ExceptionHandler::isHttpException($e))
				{
					$content = ExceptionHandler::toIlluminateResponse(ExceptionHandler::renderHttpException($e), $e);
				}
				else
				{
					$content = ExceptionHandler::toIlluminateResponse(ExceptionHandler::convertExceptionToResponse($e), $e);
				}

				Config::set('app.debug', $debugSetting);

				if (isset($content->original))
				{
					$d = new DOMDocument;
					$mock = new DOMDocument;
					$d->loadHTML($content->original);
					$body = $d->getElementsByTagName('body')->item(0);
					foreach ($body->childNodes as $child)
					{
						$mock->appendChild($mock->importNode($child, true));
					}
					$data['content'] = $mock->saveHTML();
					$data['message'] = $e->getMessage();
				}
				else
				{
					$data['content'] = $e->getMessage();
				}

				$data['request'] = [
					'IP'   => \Request::ip(),
					'Path' => \Request::path(),
				];

				$input = \Request::all();

				if (!empty($input))
				{
					$data['request']['Input'] = $input;
				}

				$user = Auth::user();
				if ($user !== null)
				{
					$data['request']['User'] = $user;
				}

				Mail::to('contact@giginfo.org')
					->send(new EmailError($data));
			}

			parent::report($e);
		}
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Exception $exception
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $exception)
	{
		if ($exception instanceof UserNotVerifiedException)
		{
			return redirect('/email-verification/error');
		}

		return parent::render($request, $exception);
	}

	/**
	 * Convert an authentication exception into an unauthenticated response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Illuminate\Auth\AuthenticationException $exception
	 * @return \Illuminate\Http\Response
	 */
	protected function unauthenticated($request, AuthenticationException $exception)
	{
		if ($request->expectsJson())
		{
			return response()->json(['error' => 'Unauthenticated.'], 401);
		}

		return redirect()->guest('login');
	}

	/**
	 * @param Exception $e
	 * @return bool
	 */
	private function notMissingToken(Exception $e)
	{
		$result = $e instanceof TokenMismatchException && (!array_key_exists('laravel_session', $_COOKIE) || !array_key_exists('XSRF-TOKEN', $_COOKIE));

		if ($result)
		{
			Log::error('TokenMismatchException: missing laravel_session/XSRF-TOKEN cookies');
		}

		return !$result;
	}
}
