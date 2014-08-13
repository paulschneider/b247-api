<?php 

$required = [
 	'channel' => [],
	'adverts' => [],
	'features' => [],
	'picks' => [],
	'channelFeed' => [],
];

$I = new ApiTester($scenario);
$I->am('An API client');
$I->wantTo('Obtain the details of a specified channel');
$I->seeInDatabase('channel', ['id' => 3, 'parent_channel' => null]);
$I->sendGET	('channel/3');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('success');

// what should be in the response object

$I->seeRequiredObjects($I, $required);

// what shouldn't be in the response object