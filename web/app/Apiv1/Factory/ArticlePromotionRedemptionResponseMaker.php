<?php namespace Apiv1\Factory;

use Lang;
use App;
use Apiv1\Mail\Notifications\PromotionRedemptionEmail;

class ArticlePromotionRedemptionResponseMaker {

	/**
	 * Fields that this process must receive to be completed
	 * @var array
	 */
	protected $requiredFields = ['code'];	

	/**
	 * PromotionRedemptionEmail
	 * @var mixed
	 */
	protected $email;

	/**
	 * The class repository to use
	 * 
	 * @var mixed
	 */
	protected $repo;

	/**
	 * class constructor
	 * 
	 * @param PromotionRedemptionEmail $email [description]
	 * 
	 */
	public function __construct(PromotionRedemptionEmail $email)
	{
		$this->email = $email;

		$this->repo = App::make('Apiv1\Repositories\Promotions\PromotionRepository');
	}

	/**
	 * Validate, process and record the redemption of a voucher code
	 * 
	 * @param  array $form [input fields posted to the endpoint]
	 * @return array       [the resulting response from this process]
	 * 
	 */
	public function redeem($form)
	{
		$userResponder = App::make( 'UserResponder' );

		# check to see if we have the accessKey header param. This is a helper function.
		if( ! userAccessKeyPresent() )
		{
			return apiErrorResponse(  'unauthorised', ['errorReason' => Lang::get('api.accessKeyNotProvided')] );
		}

		$accessKey = getAccessKey();

		// check to make sure we have all the fields required to complete the process
		if( isApiResponse( $result = $userResponder->parameterCheck($this->requiredFields, $form) ) )
		{
			// not all of the required fields were supplied
			return $result;
		}

		// okay we have everything we need. Now get the user
		if( isApiResponse( $result = $userResponder->getUserProfile($accessKey) ) )
		{
			// we couldn't find the user with the accessKey provided
			return $result;
		}

		$user = $result;

		if( isApiResponse( $result = self::isValidPromotion($form['code']) ) )
		{
			return $result;
		}

		$promotion = $result;

		# send out the promotional code to the user
		$this->email->notify( ['user' => $user, 'promotion' => $promotion] );

		# register the usage of the promotional code in the database
		$this->repo->promotionRedeemed($user, $promotion);

		# if we got to here then everything went okay and the user will get their promotional code
		return apiSuccessResponse( 'accepted', ['furtherInfo' => Lang::get('api.promotionalCodeSuccessfullyRedeemed')] );
	}

	/**
	 * Validate a supplied promotion code to ensure that it is still valid
	 * 
	 * @return [type] [description]
	 */
	public function isValidPromotion($code)
	{
		# grab the promotion from the database
		$promotion = $this->repo->get($code);

		# no promotion was found with the supplied code
		if($promotion->isEmpty())
		{
			return apiErrorResponse(  'notFound', ['errorReason' => Lang::get('api.promotionNotFound')] );
		}

		# grab the promotion from the array
		$promotion = $promotion->first();

		# check to see if its currently active. We do this here rather than the DB so we can report back to the caller
		# also check to see if the usage cap has been reached.
		if(! $promotion->is_active || $promotion->usage->count() == $promotion->upper_limit)
		{
			return apiErrorResponse(  'locked', ['errorReason' => Lang::get('api.promotionIsInactive')] );
		}

		# grab the validity data
		$validFrom = strtotime($promotion->valid_from);
		$validTo = strtotime($promotion->valid_to);

		$today = time();

		# make sure the promotion has started but not ended
		if($validFrom > $today || $validTo < $today)
        {
            return apiErrorResponse( 'forbidden', ['errorReason' => Lang::get('api.promotionOutOfRange')] );
        }
		
		# send it back
        return $promotion;
	}
}