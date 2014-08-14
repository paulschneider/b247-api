<?php

# article/CheckListingArticleDataStructureCept.php

require_once('./tests/api/variables/ListingArticleStructure.php');

$articleId = 231;
$channelId = 6;
$categoryId = 5;

// get all of the default params required for an article
$required = ListingArticleStructure::get();

$I = new ApiTester($scenario);
$I->am('An API client');
$I->wantTo('Retrieve the details of an article thats going to be sent to populate a HTML template');
$I->seeInDatabase('article', ['id' => $articleId]);
$I->seeInDatabase('channel', ['id' => $channelId]);
$I->seeInDatabase('category', ['id' => $categoryId]);

$I->sendGET	("articles?subchannel=$channelId&category={$categoryId}&article={$articleId}&dataOnly=true");

$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->canSeeHttpHeader('Content-Type','application/json');

$dataResponse = $I->grabDataFromJsonResponse('success.data.article');

$I->assertIsArray($dataResponse);

function checkListing($responseItem, $requiredItem, $I)
{
    foreach($requiredItem AS $key => $required)
    {
    	$I->checkRequiredItemExists($key, $responseItem);

        # check the type is the same (array where the should be array, boolean when a boolean and so on)
        $I->checkItsTheSameDataType($responseItem[$key], $requiredItem[$key]);        

        if(is_array($responseItem[$key]))
        {
            checkListing($responseItem[$key], $requiredItem[$key], $I);
        }
    }
}

foreach($required AS $key => $req)
{
    # make sure the response contains all of the required items
	$I->checkRequiredItemExists($key, $dataResponse);

    # check the type is the same (array where the should be array, boolean when a boolean and so on)
    $I->checkItsTheSameDataType($dataResponse[$key], $required[$key]);        

    if(is_array($dataResponse[$key]))
    {
        checkListing($dataResponse[$key], $required[$key], $I);
    }
}