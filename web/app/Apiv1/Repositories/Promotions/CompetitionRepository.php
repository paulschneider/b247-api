<?php namespace Apiv1\Repositories\Promotions;

use DB;
use Apiv1\Repositories\Models\BaseModel;

Class CompetitionRepository extends BaseModel {

	/**
	 * retrieve a specified competition by its unique row identifier
	 * 
	 * @param  int $id [unique identifier for the competition]
	 * @return Competition
	 * 
	 */
	public function get($id)
	{
		return Competition::where('id', $id)->get();
	}

	/**
	 * Check to see if a specified user has already answered a question in a competition
	 * 
	 * @param  Apiv1\Repositories\Competitions\Competition $competition
	 * @param  Apiv1\Repositories\Users\User $user
	 * @return mixed
	 * 
	 */
	public function checkEntrant($competition, $user)
	{
		return DB::table('user_competition_answer')->where('competition_id', $competition->id)->where('user_id', $user->id)->get();
	}

	/**
	 * Record a user answer to the database
	 * 
	 * @param  User $user
	 * @param  Competition $competition
	 * @param  int $answerId
	 * @return null
	 * 
	 */
	public function recordEntrant($user, $competition, $answerId)
	{
		$data = [
			'user_id' => $user->id,
			'competition_id'  => $competition->id,
			'competition_answer_id' => $answerId,
			'created_at' => getDateTime()
		];

		DB::table('user_competition_answer')->insert($data);
	}
}