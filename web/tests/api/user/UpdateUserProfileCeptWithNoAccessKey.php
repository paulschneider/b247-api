<?php 

$profileDetails = [
	'firstName' => 'Paul',
	'lastName' => 'Schneider',
	'nickName' => 'Schneidey',
	'postCode' => 'CF61 2UA',
	'facebook' => 'paul.schneider',
	'twitter' => 'pjschneidey',	
];

$I = new ApiTester($scenario);
$I->am('A registered user');
$I->wantTo('Update my profile but no accessKey has been provided.');
$I->sendPOST('user/profile', $profileDetails);
$I->seeResponseCodeIs(401);
$I->seeResponseIsJson();
$I->seeResponseContains('error');





