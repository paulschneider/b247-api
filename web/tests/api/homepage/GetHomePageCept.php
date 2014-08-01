<?php 

$required = [
 	'channels' => [],
	'adverts' => [],
	'features' => [],
	'picks' => [],
	'channelFeed' => [],
];

$I = new ApiTester($scenario);
$I->am('An API client');
$I->wantTo('Obtain the homepage data');
$I->sendGET	('/');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('success');

// what should be in the response object

$I->seeRequiredObjects($I, $required);

// what shouldn't be in the response object