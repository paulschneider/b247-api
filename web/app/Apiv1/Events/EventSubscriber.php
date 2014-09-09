<?php namespace Apiv1\Events;

class EventSubscriber {

	public function subscribe($events)
	{		
		$events->listen('record.user.search', 'Apiv1\Events\SearchRecorder@recordSearch');
	}
}