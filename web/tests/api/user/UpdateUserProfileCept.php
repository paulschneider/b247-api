<?php 

$accessKey = 'OGuzm6pDHsFwrXW6Zb0ICc1iR';

$profileDetails = [
	'firstName' => 'Paul',
	'lastName' => 'Schneider',
	'nickName' => 'Schneidey',
	'postCode' => 'CF61 2UA',
	'ageGroup' => 3,
	'facebook' => 'paul.schneider',
	'twitter' => 'pjschneidey',	
	'accessKey' => $accessKey
];

$I = new ApiTester($scenario);
$I->am('A registered user');
$I->wantTo('Update my profile.');
$I->haveHttpHeader('accessKey', $accessKey);
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST('user/profile', $profileDetails);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('accessKey');