<?php 
$I = new ApiTester($scenario);
$I->am('A registered user');
$I->wantTo('Log into my account');
$I->sendPOST('login', ['email' => 'paul.schneider@yepyep.co.uk', 'password' => 'kA6F8UWH']);
$I->seeResponseCodeIs(202);
$I->seeResponseIsJson();
$I->seeResponseContains('accessKey');





