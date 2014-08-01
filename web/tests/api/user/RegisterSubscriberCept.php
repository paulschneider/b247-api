<?php 
$I = new ApiTester($scenario);
$I->am('An un-registered user');
$I->wantTo('Register as a new subscriber');
$I->sendPOST('register', ['firstName' => 'Billy', 'lastName' => 'Bob', 'email' => 'billybob@example.com']);
$I->seeResponseCodeIs(201);
$I->seeResponseIsJson();
$I->seeResponseContains('{"success"');
$I->seeInDatabase('user', ['email' => 'billybob@example.com']);
