<?php 

# user/RegisterSubscriberCept.php

$testEmail = "schneidey2503@hotmail.com";
$newsletterList = 'daily-digest';

$I = new ApiTester($scenario);
$I->am('An un-registered user');
$I->wantTo('Register as a new subscriber');
$I->sendPOST('register', ['firstName' => 'Billy', 'lastName' => 'Bob', 'email' => $testEmail]);
$I->seeResponseCodeIs(201);
$I->seeResponseIsJson();
$I->seeResponseContains('{"success"');
$I->seeInDatabase('user', ['email' => $testEmail]);

$I->sendGET("mail/confirm-subscription?email={$testEmail}&list={$newsletterList}");
$I->seeResponseIsJson();
$I->seeResponseContains('true');
