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
		return Promotion::where('promotion.code', $promotionalCode)->with('usage')->get();
	}

	/**
	 * Check to see if a user has already requested a voucher code
	 * 
	 * @param  Apiv1\Repositories\Users\User $user
	 * @param  Apiv1\Repositories\Promotions\Promotion $promotion
	 * @return boolean [true on already redeemed | false on un-redeemed]
	 */
	public function isUserRedeemed($user, $promotion)
	{
		$result = UserRedeemedPromotion::where('user_id', $user->id)->where('promotion_id', $promotion->id)->get();

		if($result->isEmpty()) {
			return false;
		}
		else {
			return true;
		}
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

		# now check to see if we have reached the usage limit for this promotion
		$usageCount = DB::table('user_redeemed_promotion')->where('promotion_id', $promotion->id)->count();

		# if we've reached the usage limit then set the promotion to inactive so it can't be used anymore
		if( $usageCount == $promotion->upper_limit )
		{
			DB::table('promotion')->where('id', $promotion->id)->update([ 'is_active' => false, 'updated_at' => getDateTime() ]);
		}
	}
}