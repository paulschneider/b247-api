<?php

// article/CheckAppArticleResponseCept.php

require_once('./tests/api/variables/AppArticle.php');

// get all of the default params required for an article
$required = AppArticle::get();

$I = new ApiTester($scenario);
$I->am('An API client');
$I->wantTo('Retrieve the details of an article for display on a mobile device or tablet');
$I->seeInDatabase('article', ['id' => 199]);
$I->seeInDatabase('channel', ['id' => 71]);
$I->seeInDatabase('category', ['id' => 15]);

$I->sendGET	('articles?subchannel=71&category=15&article=199');

$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->canSeeHttpHeader('Content-Type','application/json');

$data = $I->grabDataFromJsonResponse('success.data');

$I->assertIsArray($data);

foreach($required AS $key => $a)
{
	$I->checkThatTheRequiredObjectsAreThere($key, $data);
}