<?php namespace Apiv1\Tools;

Class UserBroadCastOrganiser {

	/**
	 * from a provided array of broadcasts work out which the user has opted to receive
	 * 
	 * @param  array $data
	 * @return array on success, boolean on nothing to do
	 */
	public function organise($data, $user)
	{
		if(is_array($data['broadcasts']))
		{
			$opted = [];

			foreach($data['broadcasts'] AS $broadcast)
			{
				if($broadcast['isEnabled']) 
				{
					$opted[] = [
						"user_id" => $user->id,
						"communication_id" => $broadcast['id']
					];
				}
			}

			return $opted;
		}

		return false;
	}
}