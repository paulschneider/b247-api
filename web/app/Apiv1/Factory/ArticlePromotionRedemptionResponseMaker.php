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
	 * @return array [the resulting response from this process]
	 * 
	 */
	public function redeem($form)
	{
		# check that we have everything need to proceed including required params and auth creds. If all 
		# successful then the response is a user object
		if( isApiResponse($response = App::make('UserResponder')->verify($this->requiredFields, $form)) ) {
			return $response;
		}

		# we get the user back if everything went okay
		$user = $response;

		# check to see if the supplied promotional code is valid
		if( isApiResponse( $result = self::isValidPromotion($form['code']) ) ) {
			return $result;
		}

		$promotion = $result;

		# finally, ensure that this user has not redeemed the voucher previously. We prevent multiple
        # usage because some of the codes might have limits on the number of times they can be used
		if( $this->repo->isUserRedeemed($user, $promotion) ) {
			return apiErrorResponse( 'tooManyRequests', ['public' => getMessage('public.promotionalCodeAlreadyRedeemed'), 'debug' => getMessage('api.promotionalCodeAlreadyRedeemed')] );
		}

		# send out the promotional code to the user
		$this->email->notify( ['user' => $user, 'promotion' => $promotion] );

		# register the usage of the promotional code in the database
		$this->repo->promotionRedeemed($user, $promotion);

		# if we got to here then everything went okay and the user will get their promotional code
		return apiSuccessResponse( 'accepted', ['public' => getMessage('public.promotionalCodeSuccessfullyRedeemed'), 'debug' => getMessage('api.promotionalCodeSuccessfullyRedeemed')] );
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
		if($promotion->isEmpty()) {
			return apiErrorResponse( 'notFound', ['public' => getMessage('public.promotionNotFound'), 'debug' => getMessage('api.promotionNotFound')] );
		}

		# grab the promotion from the array
		$promotion = $promotion->first();

		# check to see if its currently active. We do this here rather than the DB so we can report back to the caller
		if(! $promotion->is_active)) {
			return apiErrorResponse( 'locked', ['public' => getMessage('public.promotionIsInactive'), 'debug' => getMessage('api.promotionIsInactive')] );
		}

		# check to see if the usage cap for this promotion has been reached
		if($promotion->usage->count() == $promotion->upper_limit) {
			return apiErrorResponse( 'locked', ['public' => getMessage('public.promotionLimitReached'), 'debug' => getMessage('api.promotionLimitReached')] );
		}

		# grab the validity data
		$validFrom = strtotime($promotion->valid_from);
		$validTo = strtotime($promotion->valid_to);

		$today = time();

		# make sure the promotion has started but not ended
		if($validFrom > $today || $validTo < $today) {
            return apiErrorResponse( 'forbidden', [ 'public' => getMessage('public.promotionOutOfRange'), 'debug' => getMessage('api.promotionOutOfRange')] );
        }    
        
		# send it back
        return $promotion;
	}
}