<?php namespace Apiv1\Tools;

Class UserDistrictOrganiser {

	/**
	 * from a provided array of districts work out which the user has opted to promote
	 * @param  array $data
	 * @return array on success, boolean on nothing to do
	 */
	public function organise($data)
	{
		if(is_array($data['districts']))
		{
			$promoted = [];

			foreach($data['districts'] AS $district)
			{
				if($district['isPromoted']) {
					$promoted[] = $district['id'];
				}
			}

			return $promoted;
		}

		return false;
	}

	/**
	 * regardless of the order of the articles in the supplied array, work out if some of them can be promoted based
	 * on the user district preferences
	 * 
	 * @param  Apiv1\Repositories\Users\User $user
	 * @param  array $articles [a list of articles produced retrieved from the database]
	 * @return $articles
	 */
	public function promoteDistricts($user, $articles)
	{
		# if we don't have a user or there are no user districts then just return the original article list
		if( is_null($user) || ! isset($user->districts) || empty($user->districts)) {
			return $articles;
		}

		# grab the districts from the user and init some empty arrays to use
		$districts = $user->districts;	
		$promoted = [];
		$standard = [];

		# go through all of the articles in the list
		foreach($articles AS $key => $article)
		{
			# set the promoted flag to false for everything
			$article['is_promoted'] = false;

			# if we find the article is from a district the user want to see
			if(in_array($article['district'], $districts))
			{
				# then grab the array key for the district so we can remove it
				$district = array_keys($districts, $article['district']);

				# we only promote one article from each district so remove the district now its been used				
				unset($districts[$district[0]]);
				
				# set the article promoted flag to true
				$article['is_promoted'] = true;

				# add the article into a promoted list
				$promoted[] = $article;	
			}
			# if its not from a district the user wants to see then just add it into the standard article list
			else {
				$standard[] = $article;
			}
		}

		# ... finally merge the promoted list with the standard articles with the promoted articles at the front
		return array_merge($promoted, $standard);
	}
}