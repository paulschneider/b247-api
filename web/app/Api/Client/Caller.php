<?php namespace Api\Client;

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

		// getPath()
		// getUrl()

		try {
		   $response = $this->client->send($request)->json();

		   if( isset($response['success']) )
		   {
		   		return $response['success']['data'];	
		   }
		   else
		   {
		   		exit('Api\Client\Caller::get() -> could not get the data from the API');
		   }		   
		} 
		catch (ClientException $e) {
			dd($e->getMessage());

			$response = $e->getResponse()->json();
			\App::abort(404, $response['error']['message']);
		}

		return $response->json();
	}

	public function setRequestHeaders($request, $headers = [])
	{
		if( count($headers) > 0 )
		{
			foreach($headers AS $header => $value)
			{
				if( ! $request->getHeader($header) )
				{
					$request->setHeader($header, $value);
				}				
			}
		}

		return $request;
	}

	public function setQueryString($params = [])
	{
		// only do this if we have some parameters to submit
		if( count($params) > 0)
		{
			$queryStr = "?";

			// go through each of the supplied parameters and created a query string
			foreach( $params AS $key => $param )
			{
				$queryStr .= $key . '=' . $param . '&';
			}

			// remove the trailing '&' 
			if( substr($queryStr, strlen($queryStr)-1, strlen($queryStr)) == "&" )
			{
				$queryStr = substr($queryStr, 0, strlen($queryStr)-1);
			}

			// append the query string to the endpoint
			$this->endpoint .= $queryStr;
		}
	}

	public function post($path, $params)
	{
		// to do
	}
}