<?php

namespace Dragon\Api;

use Dragon\Api\Concerns\GuzzleTrait;
use Dragon\Database\Option;
use Dragon\Support\Encryptor;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

abstract class RestfulOauth2 {
	use GuzzleTrait;
	
	protected string $productionUrl = "";
	protected string $sandboxUrl = "";
	protected string $tokenPath = "";
	protected string $clientIdSettingsKey = "";
	protected string $clientSecretSettingsKey = "";
	
	protected string $modeSettingsKey = "";
	protected string $sandboxModeIdentifiedBy = "sand";
	protected string $tokenCacheSuffix = "";
	
	protected string $clientId = "";
	protected string $clientSecret = "";
	
	protected string $authType = "Bearer";
	protected array $settings = [];
	
	public function __construct(array $settings = []) {
		$this->settings = $settings;
		$this->clientId = Encryptor::decrypt(Option::get($this->clientIdSettingsKey));
		$this->clientSecret = Encryptor::decrypt(Option::get($this->clientSecretSettingsKey));
		
		$token = $this->makeToken();
		$this->guzzle = new Client($this->filterGuzzleParams([
			'base_uri' => $this->getUrl(),
			'headers' => [
				'Authorization' => $this->authType . ' ' . $token,
			],
		]));
	}
	
	protected function filterGuzzleParams(array $guzzleParams) {
		return $guzzleParams;
	}
	
	protected function getUrl() {
		$mode = Option::get($this->modeSettingsKey, $this->sandboxModeIdentifiedBy);
		return $mode === $this->sandboxModeIdentifiedBy ? $this->sandboxUrl : $this->productionUrl;
	}
	
	protected function makeToken() {
		$cachedToken = Cache::get(static::class . '_oauth_token' . $this->tokenCacheSuffix);
		if (!empty($cachedToken)) {
			return $cachedToken;
		}
		
		$response = $this->jsonCall(function () {
			$tokenClient = new Client([
				'base_uri' => $this->getUrl(),
			]);
			
			return $tokenClient->post($this->tokenPath, [
				'form_params' => [
					'grant_type'	=> 'client_credentials',
					'client_id'		=> $this->clientId,
					'client_secret'	=> $this->clientSecret,
				],
			]);
		});
			
			if (empty($response)) {
				return;
			}
			
			$token = $this->getAccessTokenFromResponse($response);
			$expiry = $this->getTokenExpiryFromResponse($response);
			if (!empty($expiry)) {
				Cache::set(static::class . '_oauth_token' . $this->tokenCacheSuffix, $token, $expiry);
			}
			
			return $token;
	}
	
	protected function getAccessTokenFromResponse(\stdClass $response) {
		return $response->access_token;
	}
	
	protected function getTokenExpiryFromResponse(\stdClass $response) {
		return $response->expires_in;
	}
}
