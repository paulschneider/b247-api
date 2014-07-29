<?php

// this is an included file and not a directly run cept. It provides common check for all article types

require_once('./tests/api/variables/DisplayType.php');
require_once('./tests/api/variables/ArticleAssignmentChannel.php');
require_once('./tests/api/variables/ArticleAssignmentSubChannel.php');
require_once('./tests/api/variables/ArticleAssignmentCategory.php');
require_once('./tests/api/variables/Media.php');

/**
* Check that each of the required display type elements are present
*/
$displayType = $article['displayType'];
$I->assertIsArray($displayType);

foreach(DisplayType::get() AS $key => $a)
{
	$I->checkThatTheRequiredObjectsAreThere($key, $displayType);
}

/**
* Check that each of the required assignment/channel elements are present
*/
$assignmentChannel = $article['assignment']['channel'];
$I->assertIsArray($assignmentChannel);

foreach(ArticleAssignmentChannel::get() AS $key => $a)
{
	$I->checkThatTheRequiredObjectsAreThere($key, $assignmentChannel);
}

/**
* Check that each of the required assignment/sub-channel elements are present
*/
$assignmentSubChannel = $article['assignment']['subChannel'];
$I->assertIsArray($assignmentChannel);

foreach(ArticleAssignmentSubChannel::get() AS $key => $a)
{
	$I->checkThatTheRequiredObjectsAreThere($key, $assignmentSubChannel);
}

/**
* Check that each of the required assignment/category elements are present
*/
$assignmentCategory = $article['assignment']['category'];
$I->assertIsArray($assignmentCategory);

foreach(ArticleAssignmentCategory::get() AS $key => $a)
{
	$I->checkThatTheRequiredObjectsAreThere($key, $assignmentCategory);
}

/**
* Check that each of the required media elements are present
*/
$media = $article['media'];
$I->assertIsArray($media);

foreach(Media::get() AS $key => $a)
{
	$I->checkThatTheRequiredObjectsAreThere($key, $media);
}