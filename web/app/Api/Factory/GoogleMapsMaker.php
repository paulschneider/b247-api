<?php namespace Api\Factory;

use Config;
use ApiClient;

//https://developers.google.com/maps/documentation/geocoding/

Class GoogleMapsMaker {

	public function translatePostcode($postcode)
	{
		$address = new \stdClass();

		$apiKey = Config::get('googleapi.key');
		$response = ApiClient::get('https://maps.googleapis.com/maps/api/geocode/json', [ 'address' => $postcode, 'key' => $apiKey ]);

		if( $response['status'] == "OK" )
		{
			$address->lat = $response['results'][0]['geometry']['location']['lat'];
			$address->lon = $response['results'][0]['geometry']['location']['lng'];

			return $address;
		}
	}
}