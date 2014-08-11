<?php namespace Apiv1\Repositories\Promotions;

use DB;
use Apiv1\Repositories\Models\BaseModel;

Class PromotionRepository extends BaseModel {

	/**
	 * retrieve the details of promotional code
	 * 
	 * @param  string $promotionalCode [unique identifier for the promotional code]
	 * 
	 * @return array
	 */
	public function get($promotionalCode)
	{
		return Promotion::where('code', $promotionalCode)->get();
	}

	/**
	 * Record a user promotion redemption in the database
	 * 
	 * @param  Apiv1\Repositories\Users\User $user
	 * @param  Apiv1\Repositories\Promotions\Promotion $promotion
	 * 
	 * @return null
	 */
	public function promotionRedeemed($user, $promotion)
	{
		# the data to insert
		$data = [
			"user_id" => $user->id,
			"promotion_id" => $promotion->id,
			"requested_at" => getDateTime(),
		];

		# do the insert quietly
		DB::table('user_redeemed_promotion')->insert($data);
	}
}