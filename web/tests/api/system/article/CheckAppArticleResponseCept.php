<?php

// article/CheckAppArticleResponseCept.php

require_once('./tests/api/variables/AppArticle.php');

// get all of the default params required for an article
$required = AppArticle::get();

$I = new ApiTester($scenario);
$I->am('An API client');
$I->wantTo('Retrieve the details of an article for display on a mobile device or tablet');
$I->seeInDatabase('article', ['id' => 231]);
$I->seeInDatabase('channel', ['id' => 6]);
$I->seeInDatabase('category', ['id' => 5]);

$I->sendGET	('articles?subchannel=6&category=5&article=231');

$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->canSeeHttpHeader('Content-Type','application/json');

$data = $I->grabDataFromJsonResponse('success.data');

$I->assertIsArray($data);

foreach($required AS $key => $a)
{
	$I->checkThatTheRequiredObjectsAreThere($key, $data);
}