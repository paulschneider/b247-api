<?php 
$I = new ApiTester($scenario);
$I->am('A registered user');
$I->wantTo('Request a forgotten password reset');
$I->sendPOST('user/password?forgotten=true', ['email' => 'paul.schneider@yepyep.co.uk', 'password' => 'password']);
$I->seeResponseCodeIs(202);
$I->seeResponseIsJson();
$I->seeResponseContains('Accepted');





