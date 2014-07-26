<?php namespace Api\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

Class Caller {

	protected $client;
	protected $endpoint;

	public function __construct($client)
	{
		$this->client = $client;
	}

	public function get($endpoint = "/", $params = [], $headers = [])
	{
		$this->endpoint = $endpoint;

		$request = $this->client->createRequest('GET', $this->endpoint, [
			'headers' => $headers,
			'query' => $params
		]);

		return $this->send($request);
	}

	public function post($endpoint = "/", $data = [], $headers = [])
	{
		$this->endpoint = $endpoint;

		$request = $this->client->createRequest('POST', $this->endpoint, ['json' => $data]);

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