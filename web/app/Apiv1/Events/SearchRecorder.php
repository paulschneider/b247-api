<?php namespace Apiv1\Events;

use Event;
use Apiv1\Repositories\SearchRepository;

class SearchRecorder {

	/**
	 * this event is triggered whenever a search is carried out. The listener is defined
	 * within Apiv1\Events\EventSubscriber.php. All events are subscribed to within 
	 * Apiv1\EventsEventServiceProvider.php
	 * 
	 * @param  array $data [details of the search just carried out]
	 * @return null
	 */
	public function recordSearch($data)
	{
		$entries = [];

		foreach($data AS $term)
		{
			if(! array_key_exists($term->keyword, $entries)) {
				$entries[$term->keyword] = 1;
			}
			else {
				$entries[$term->keyword]++;	
			}
		}
	}	
}