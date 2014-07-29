<?php 
$I = new ApiTester($scenario);
$I->am('A registered user');
$I->wantTo('Change my password, but I provide an incorrect account password');
$I->sendPOST('user/password', ['email' => 'paul.schneider@yepyep.co.uk', 'password' => 'sdgsdgsdg', 'newPassword' => 'password1']);
$I->seeResponseCodeIs(401);
$I->seeResponseIsJson();
$I->seeResponseContains('error');





