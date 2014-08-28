<?php namespace Apiv1\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Config;

Class Caller {

	protected $client;
	protected $endpoint;

	public function __construct()
	{
		$this->client = new Client([ 
			'base_url' => Config::get('api.baseUrl'),
			'defaults' => [
				# we had a password on the site at one point and these were the 
				# credentials to get the API through
				'auth' => ['b247', 'master'] 
			]
		]);
	}

	public function get($endpoint = "", $params = [], $headers = [])
	{
		$this->endpoint = $endpoint;

		if( ! anExternalUrl($this->endpoint) )
		{
			$this->endpoint = $this->client->getBaseUrl().$this->endpoint;	
		}		

		$request = $this->client->createRequest('GET', $this->endpoint, [
			'headers' => $headers,
			'query' => $params
		]);

		return $this->send($request);
	}

	public function post($endpoint = "/", $data = [], $headers = [])
	{
		$this->endpoint = $endpoint;

		$request = $this->client->createRequest('POST', $this->endpoint, [
			'body' => $data,
			'headers' => $headers
		]);

		return $this->send($request);
	}

	public function send($request)
	{
		try {
		   $response = $this->client->send($request)->json();

		   if( isset($response['success']) )
		   {
		   		return $response['success']['data'];	
		   }
		
			return $response;   

		} 
		catch (ClientException $e) {
			dd($e->getMessage());

			$response = $e->getResponse()->json();
			\App::abort(404, $response['error']['message']);
		}

		return $response->json();
	}
}