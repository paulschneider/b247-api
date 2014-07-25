<?php

/*
* if a device makes an API request for HTML from the website the links within that HTML need
* to be translated into device friendly paths rather than the SEO friendly version the website uses
*
* ......... the following does that.
*
*/

function makeChannelLink($channel)
{
	return Config::get('constants.deviceBaseUrl') . 'channel/' . $channel;
}

function makeSubChannelPath($subChannel, $type)
{
	return Config::get('constants.deviceBaseUrl') . 'subchannel/' . $subChannel . '/' . strtolower($type);	
}

function makeCategoryPath($category, $type, $subChannel)
{
	return Config::get('constants.deviceBaseUrl') . 'category/' . $category . '/' . strtolower($type) . '/articles?subChannel=' . $subChannel;	
}

function makeArticleLink($subChannel, $category, $article)
{
	return Config::get('constants.deviceBaseUrl') . 'articles?subchannel=' . $subChannel . '&category=' . $category . '&article=' . $article;	
}