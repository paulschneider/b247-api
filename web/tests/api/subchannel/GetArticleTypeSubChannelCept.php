<?php 

$required = [
 	'channel' => [],
	'adverts' => [],
	'articles' => [],
	'pagination' => [],
];

$forbidden = [
	'days' => []
];

$I = new ApiTester($scenario);
$I->am('An API client');
$I->wantTo('Obtain the details of a sub-channel of type article');
$I->seeInDatabase('channel', ['id' => 4, 'parent_channel' => 1]);
$I->sendGET	('subchannel/4/article');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();

// what should be in the response object

$I->seeRequiredObjects($I, $required);

// what shouldn't be in the response object

$I->dontSeeInTheResponse($I, $forbidden);