<?php 
$I = new ApiTester($scenario);
$I->am('A registered user');
$I->wantTo('Change my password');
$I->sendPOST('user/password', ['email' => 'paul.schneider@yepyep.co.uk', 'password' => 'kA6F8UWH', 'newPassword' => 'password']);
$I->canSeeResponseCodeIs(202);
$I->seeResponseIsJson();
$I->seeResponseContains('accessKey');





