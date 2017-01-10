<?php

namespace App\Http\Controllers;

use Exception;
use InfyOm\Generator\Utils\ResponseUtil;
use Response;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Throwable;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
	public function sendResponse($result, $message)
	{
		return Response::json(ResponseUtil::makeResponse($message, $result));
	}

	public function sendError($error, $code = 404)
	{
		return Response::json(ResponseUtil::makeError($error), $code);
	}

	public function render($__php, $__data)
	{
		$__data['__env'] = app(\Illuminate\View\Factory::class);

		$obLevel = ob_get_level();
		ob_start();
		extract($__data, EXTR_SKIP);

		try
		{
			eval('?' . '>' . $__php);
		} catch (Exception $e)
		{
			while (ob_get_level() > $obLevel) ob_end_clean();
			throw $e;
		} catch (Throwable $e)
		{
			while (ob_get_level() > $obLevel) ob_end_clean();
			throw new FatalThrowableError($e);
		}

		return ob_get_clean();
	}

}
