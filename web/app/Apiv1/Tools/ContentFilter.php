<?php namespace Apiv1\Tools;

use App;

Class ContentFilter {

	/**
	 * Authenticated user object
	 * @var Apiv1\Repositories\Users\User
	 */
	protected $user;

	/**
	 * check to see if a category/sub-channel combination exists in the inactive_categories of the user account
	 * 
	 * @param  int  $category   [category identifier]
	 * @param  int  $subChannel [subChannel identifier]
	 * @return boolean
	 */
	public function isCategoryUserEnabled($category, $subChannel)
	{
		if( ! is_null($this->user) && count($this->user->inactive_categories) > 0)
		{		
			# if we find a combination of catId and subChannelId then the user has opted out of this category
			if(array_key_exists($category, $this->user->inactive_categories)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * go through a list of articles and if the user has opted out of them, remove them from the
	 * provided list of articles
	 * 
	 * @param  array $articles
	 * @return array $articles
	 */
	public function filterArticlesByUserCategory($articles)
	{
		# if we have a user, they have some inactive categories AND we have some articles to go through 
		if( ! is_null($this->user) && count($this->user->inactive_categories) > 0 && is_array($articles))
		{
			# an array into which we can put all of the articles the use does want to see
			$kept = [];

			$discarded = [];

			# go through the articles
			foreach($articles AS $article)	
			{
				# get the category and subChannel ID from each
				$articleSubChannel = $article['location'][0]['subChannelId'];
				$articleCategory = $article['location'][0]['categoryId'];

				# call this classes isCategoryUserDisabled method to check whether we want to keep 
				# the article
				if($this->isCategoryUserEnabled($articleCategory, $articleSubChannel) ) {
					# and if so, put it in the kept array
					$kept[] = $article;
				}
				# just for debugging, keep the ones aside that the user doesn't want
				else {
					$discarded[] = $article;
				}
			}

			# .... and send it back as if nothing has happened
			return $kept;
		}

		# otherwise just send the articles back as they were
		return $articles;
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