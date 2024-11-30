<?php

namespace Dragon\Exceptions;

use Roots\Acorn\Exceptions\Handler as AcornHandler;
use Illuminate\Routing\Router;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Dragon\Core\Config;

class Handler extends AcornHandler {
	public static function shouldShow(bool $true, \Throwable $e) {
		$isDebug = Config::get('app.debug', false);
		return !$isDebug || !in_array($e->getMessage(), Config::get('errors.ignore_messages', []));
	}
	
	public function render($request, \Throwable $e)
	{
		$e = $this->mapException($e);
		
		if (method_exists($e, 'render') && $response = $e->render($request)) {
			return Router::toResponse($request, $response);
		}
		
		if ($e instanceof Responsable) {
			return $e->toResponse($request);
		}
		
		$e = $this->prepareException($e);
		
		if ($response = $this->renderViaCallbacks($request, $e)) {
			return $response;
		}
		
		return match (true) {
			$e instanceof HttpResponseException => $e->getResponse(),
			$e instanceof ValidationException => $this->convertValidationExceptionToResponse($e, $request),
			default => $this->prepareResponse($request, $e),
		};
	}
}
