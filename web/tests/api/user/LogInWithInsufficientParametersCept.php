<?php 
$I = new ApiTester($scenario);
$I->am('A registered user');
$I->wantTo('Log into my account but dont provide enough details');
$I->sendPOST('login', []);
$I->seeResponseCodeIs(412);
$I->seeResponseIsJson();
$I->seeResponseContains('Not enough arguments');





