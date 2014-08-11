<?php 
$I = new ApiTester($scenario);
$I->am('A registered user');
$I->wantTo('Change my password');
$I->sendPOST('user/password', ['email' => 'paul.schneider@yepyep.co.uk', 'password' => 'password']);
$I->seeResponseCodeIs(412);
$I->seeResponseIsJson();
$I->seeResponseContains('error');





