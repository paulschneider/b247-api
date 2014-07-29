<?php
namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class ApiHelper extends \Codeception\Module
{
	public function seeRequiredObjects($I, $required)
	{	
		$I->grabDataFromJsonResponse('success.data');		

		foreach($required AS $key => $item)
		{
			$I->grabDataFromJsonResponse('success.data.' . $key);
		}
	}

	public function dontSeeInTheResponse($I, $forbidden)
	{
		foreach($forbidden AS $key => $item)
		{
			//$I->dontSeeResponseContainsJson('success.data.' . $key);
		}
	}

	public function assertIsArray($var)
	{
		$this->assertTrue(is_array($var));
	}

	public function checkThatTheRequiredObjectsAreThere($key, $array)
	{
		$this->assertTrue(array_key_exists($key, $array));	
	}

	public function gotAnArticleFromTheResponse($data)
	{
		foreach($data AS $key => $article)
		{
			if($article['isAdvert'] == false)
			{
				return $article;
			}			
		}	
	}
}