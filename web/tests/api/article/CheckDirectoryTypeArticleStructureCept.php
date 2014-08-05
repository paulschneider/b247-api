<?php

# article/CheckDirectoryTypeArticleStructureCept.php

require_once('./tests/api/variables/Article.php');

// get all of the default params required for an article
$required = Article::get();

// add any extra requirements that differ between the article types

$I = new ApiTester($scenario);
$I->am('An API client');
$I->wantTo('Retrieve the details of an article');
$I->seeInDatabase('article', ['id' => 202]);
$I->seeInDatabase('channel', ['id' => 6]);
$I->sendGET	('category/6/article/articles?subChannel=7');

$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->canSeeHttpHeader('Content-Type','application/json');

$articles = $I->grabDataFromJsonResponse('success.data.articles');

$I->assertIsArray($articles);

$article = $I->gotAnArticleFromTheResponse($articles);
$I->assertIsArray($article);

foreach($required AS $key => $a)
{
	$I->checkThatTheRequiredObjectsAreThere($key, $article);
}

include './tests/api/article/CheckMainArticleStructure.php';