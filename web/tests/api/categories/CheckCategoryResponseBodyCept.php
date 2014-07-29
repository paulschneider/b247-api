<?php

# categories/CheckCategoryResponseBodyCept.php

require_once('./tests/api/variables/DirectoryCategory.php');

$I = new ApiTester($scenario);
$I->am('An API client');
$I->wantTo('Retrieve the details of category of type directory');
$I->seeInDatabase('channel', ['id' => 71]);
$I->seeInDatabase('category', ['id' => 5]);
$I->sendGET	('category/15/article/articles?subChannel=71');

$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->canSeeHttpHeader('Content-Type','application/json');

$data = $I->grabDataFromJsonResponse('success.data');

$I->assertIsArray($data);

foreach(DirectoryCategory::get() AS $key => $a)
{
	$I->checkThatTheRequiredObjectsAreThere($key, $data);
}
