<?php 

# subchannel/GetListingTypeSubChannelCept.php

$required = [
 	'channel' => [],
	'adverts' => [],
	'days' => [],
	'numberOfDays' => [],
];

$forbidden = [
	'articles' => [],
	'pagination' => [],
];

$I = new ApiTester($scenario);
$I->am('An API client');
$I->wantTo('Obtain the details of a sub-channel of type listing');
$I->seeInDatabase('channel', ['id' => 6, 'parent_channel' => 2]);
$I->sendGET	('subchannel/6/listing');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->canSeeHttpHeader('Content-Type','application/json');

// what should be in the response object

$I->seeRequiredObjects($I, $required);

// what shouldn't be in the response object

$I->dontSeeInTheResponse($I, $forbidden);

$data = $I->grabDataFromJsonResponse('success.data.days');

$I->assertIsArray($data, "data is an array");

$required = [
 	'publication' => [],
	'categories' => [],
	'articles' => [],
];

foreach($data[0] AS $key => $item)
{
	$I->checkThatTheRequiredObjectsAreThere($key, $required);
}