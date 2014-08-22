<?php 

# user/CheckUserInvalidAccessKeyCept.php

$accessKey = 'D5F0DDA4AD8B974_XXX';

$I = new ApiTester($scenario);
$I->am('a registered user');
$I->wantTo('grab authenticated content but I have an invalid accessKey');
$I->sendGET('/', ['accessKey' => $accessKey]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('{"success"');
