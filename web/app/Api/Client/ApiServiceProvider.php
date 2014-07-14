<?php namespace Api\Client;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

Class ApiServiceProvider extends ServiceProvider {

	public function register()
	{	
		$this->app->bind('ApiClient', function(){
			$client = new Client( [ 'base_url' => \Config::get('api.baseUrl') ] );	

			return new Caller($client);
		});
	}
}