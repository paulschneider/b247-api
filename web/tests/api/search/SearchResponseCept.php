<?php 

$I = new ApiTester($scenario);
$I->am('A user');
$I->wantTo('Search the API for a specified term');
$I->sendGET	('search?q=hippo');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('success');
$I->seeResponseContains('adverts');
$I->seeResponseContains('searchResults');
$I->seeResponseContains('resultCount');
$I->seeResponseContains('pagination');
$I->seeInDatabase('search', ['term' => 'hippo']);
