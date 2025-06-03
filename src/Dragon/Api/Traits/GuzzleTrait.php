<?php

namespace Dragon\Api\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Exception\RequestException;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiterMiddleware;
use Illuminate\Support\Facades\Log;

trait GuzzleTrait {
	private ?Client $guzzle = null;
	private ?\stdClass $error = null;
	
	public function getError() : ?\stdClass {
		return $this->error;
	}
	
	public function getGuzzle() : Client {
		return $this->guzzle;
	}
	
	public function jsonCall(callable $request) {
		$this->error = null;
		try {
			$response = $request();
			return json_decode((string)$response->getBody());
			
		} catch (RequestException $e) {
			return $this->handleGuzzleException($e);
		}
	}
	
	public function handleGuzzleException(\Exception $e, array $ignoreErrorCodes = []) {
		$shouldLog = !in_array($e->getCode(), $ignoreErrorCodes);
		
		if ($shouldLog) {
			Log::error(static::class . " " . $e->getMessage());
		}
		$response = $e->getResponse();
		
		if (empty($response)) {
			$error = new \stdClass();
			$error->exception = $e->getMessage();
			$this->error = $error;
		} else {
			$jsonError = (string)$e->getResponse()->getBody();
			$this->error = json_decode($jsonError);
			
			if ($shouldLog) {
				Log::error(static::class . " " . $jsonError);
			}
		}
		
		return null;
	}
	
	public function makeThottleHandlerPerSecond(int $requestsPerSecond) {
		$stack = HandlerStack::create();
		$stack->push(RateLimiterMiddleware::perSecond($requestsPerSecond));
		
		return $stack;
	}
	
	public function makeThottleHandlerPerMinute(int $requestsPerMinute) {
		$stack = HandlerStack::create();
		$stack->push(RateLimiterMiddleware::perMinute($requestsPerMinute));
		
		return $stack;
	}
}
