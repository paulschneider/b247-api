<?php namespace Apiv1\Repositories\Districts;

use Apiv1\Repositories\Models\BaseModel;

Class DistrictsRepository extends BaseModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'district';

	public function getDistricts()
	{
		return static::orderBy('name', 'asc')->get();
	}
}