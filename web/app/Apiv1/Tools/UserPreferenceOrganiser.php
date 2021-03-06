<?php namespace Apiv1\Tools;

use stdClass;
use Lang;
use Apiv1\Repositories\Users\User;
use Apiv1\Exceptions\InvalidDataSupply;

Class UserPreferenceOrganiser {

	public function organise(User $user, $preferences)
	{
		$channels = [];
		$categories = [];
		$result = new stdClass();

		// make sure its an array and there are items to go through
		if( is_array($preferences['channels']) && count($preferences['channels']) )
		{
			// go through all supplied channels preferences
			foreach($preferences['channels'] AS $channel)
			{
				// the top level preferences are the channels
				if(isset($channel['isEnabled']) and ! $channel['isEnabled'] )
				{
					$channels[] = [
						'user_id' => $user->id,
						'channel_id' => $channel['id']
					];
				}

				// and we could also have some subChannels
				if( isset($channel['subChannels']) )
				{
					foreach( $channel['subChannels'] AS $subChannel )
					{
						if(isset($subChannel['isEnabled']) and ! $subChannel['isEnabled'] )
						{
							$channels[] = [
								'user_id' => $user->id,
								'channel_id' => $subChannel['id']
							];
						}					

						// and the subChannels might have categories
						if( isset($subChannel['categories']) )
						{
							foreach( $subChannel['categories'] AS $category )
							{
								if(isset($category['isEnabled']) and ! $category['isEnabled'] )
								{
									$categories[] = [
										'user_id' => $user->id,
										'sub_channel_id' => $subChannel['id'],
										'category_id' => $category['id']
									];
								}
							}
						}
					}
				}
			}
		}
		else
		{
			// caught in app/start/global.php
			throw new InvalidDataSupply(Lang::get('api.userPreferencesAreNotAnArray'));
		}

		// and finally return an object containing the result of the organisation
		$result->channels = $channels;
		$result->categories = $categories;

		return $result;
	}
}