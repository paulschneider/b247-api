<?php 
$I = new ApiTester($scenario);
$I->am('A registered user');
$I->wantTo('Request a forgotten password reset, but I didnt supply an email address');
$I->sendPOST('user/password?forgotten=true', []);
$I->seeResponseCodeIs(412);
$I->seeResponseIsJson();
$I->seeResponseContains('error');





