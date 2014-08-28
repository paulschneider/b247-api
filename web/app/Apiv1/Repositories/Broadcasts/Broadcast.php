<?php namespace Apiv1\Repositories\Broadcasts;

use Apiv1\Repositories\Models\BaseModel;

class Broadcast extends BaseModel {

	/**
	 * which database table do we want to use
	 * 
	 * @var string
	 */
	public $table = "communication";

}