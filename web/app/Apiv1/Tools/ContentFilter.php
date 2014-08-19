<?php namespace Apiv1\Tools;

use App;

Class ContentFilter {

	/**
	 * Authenticated user object
	 * @var Apiv1\Repositories\Users\User
	 */
	protected $user;

	public function isCategoryUserEnabled($category, $subChannel)
	{
		if( ! is_null($this->user) && count($this->user->inactive_categories) > 0)
		{		
			# if we find a combination of catId and subChannelId then the user has opted out of this category
			if(array_key_exists($category, $this->user->inactive_categories) && $this->user->inactive_categories[$category]['subchannel'] == $subChannel) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Set this classes user object
	 * 
	 * @param Apiv1\Repositories\Users\User $user
	 */
	public function setUser($user)
	{
		$this->user = $user;

		# return the class so we can chain more methods if needed
		return $this;
	}
}