<?php namespace Apiv1\Events;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider {

	/**
	* Register
	*/
	public function register()
	{
		$this->app->events->subscribe(new \Apiv1\Events\EventSubscriber);
	}
}