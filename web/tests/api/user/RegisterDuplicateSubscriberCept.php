<?php 
$I = new ApiTester($scenario);
$I->am('an existing subscriber');
$I->wantTo('Register as a new subscriber, but I have already subscribed');
$I->sendPOST('register', ['firstName' => 'Paul', 'lastName' => 'Schneider', 'email' => 'paul.schneider@yepyep.co.uk']);
$I->seeResponseCodeIs(422);
$I->seeResponseIsJson();
$I->seeResponseContains('The email has already been taken');
