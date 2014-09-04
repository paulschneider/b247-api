<?php namespace Apiv1\Tools;

use stdClass;

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
			$optIns = []; $optOuts = [];

			foreach($data['broadcasts'] AS $broadcast)
			{
				$pref = [
					"user_id" => $user->id,
					"communication_id" => $broadcast['id']
				];

				# the user is opting to receive the communication
				if($broadcast['isEnabled']) {
					$optIns[] = $pref;
				}
				# they've chosen not to receive it
				else {
					$optOuts[] = $pref;
				}
			}

			$response = new stdClass();

			$response->optIns = $optIns;
			$response->optOuts = $optOuts;

			return $response;
		}

		return false;
	}
}