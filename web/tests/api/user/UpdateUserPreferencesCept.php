<?php 

require_once('./app/storage/test-data/user-prefs.php');

$I = new ApiTester($scenario);
$I->am('A registered user');
$I->wantTo('Update my channel, subChannel and/or category preferences');
$I->sendPOST('user/preferences', $form);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('success');





