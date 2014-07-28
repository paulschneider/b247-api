<?php namespace Apiv1\Client;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Config;

Class ApiServiceProvider extends ServiceProvider {

	public function register()
	{	
		$this->app->bind('ApiClient', function(){
			$client = new Client( [ 'base_url' => Config::get('api.baseUrl') ] );	

			return new Caller($client);
		});
	}
}