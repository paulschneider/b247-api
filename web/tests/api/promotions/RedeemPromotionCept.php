<?php 

# promotions/RedeemPromotionCept.php

$code = "X3D90ZKRMZ";
$accessKey = 'D5F0DDA4AD8B974';
$promotionId = 2;

$I = new ApiTester($scenario);
$I->am('a registered user');
$I->wantTo('redeem a promotion code');
$I->seeInDatabase('promotion', ['code' => $code]);
$I->sendPOST('promotion/redeem', ['code' => $code, 'accessKey' => $accessKey]);
$I->seeResponseCodeIs(202);
$I->seeResponseIsJson();
$I->seeResponseContains('{"success"');

$I->seeInDatabase('user_redeemed_promotion', ['promotion_id' => $promotionId ]);
