<?php namespace Apiv1\Repositories\Broadcasts;

use Apiv1\Repositories\Broadcasts\Broadcast;
use Apiv1\Repositories\Models\BaseModel;

Class BroadcastRepository extends BaseModel {

	/**
	 * get a list of all publicly available communication broadcast types
	 * 
	 * @return mixed
	 */
	public function getBroadcasts()
	{
		return Broadcast::whereIsActive(true)->get();
	}
}