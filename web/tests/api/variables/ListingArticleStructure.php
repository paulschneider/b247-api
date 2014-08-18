<?php

Class ListingArticleStructure {

	public static $body = [
	 	'id' => "",
		'title' => "",
		'sefName' => "",
		'subHeading' => "",
		'body' => "",
		'bodyContinued' => "",
		'author' => "",
		'mapItems' => [
			"title" => "",
			"lat" => "",
			"lon" => "",
		],
		"path" => "",
		"shareLink" => "",
		"isAdvert" => false,
		"published" => "",
		"displayType" => [
			"id" => 1,
			"type" => 1,
		],
		"displayStyle" => 1,
		"assignment" => [
			"channel" => [
				"id" => 1,
				"name" => "",
				"sefName" => "",
				"path" => ""
			],
			"subChannel" => [
				"id" => 1,
				"name" => "",
				"sefName" => "",
				"path" => ""
			],
			"category" => [
				"id" => 1,
				"name" => "",
				"sefName" => "",
				"path" => ""
			],
		],
		"media" => [
			"filepath" => "",
			"alt" => "",			
			"title" => "",
			"width" => "",
			"height" => "",
		],
		"event" => [
			"details" => [
				"id" => 1,
				"title" => "",
				"sefName" => "",
				"showDate" => "",
				"showTime" => "",
				"epoch" => 1,
				"price" => "",
				"url" => "",
				"performances" => []
			],
			"venue" => [
				"id" => "",
				"name" => "",
				"sefName" => "",
				"address1" => "",
				"address2" => "",
				"address3" => "",
				"postcode" => "",
				"email" => "",
				"facebook" => "",
				"twitter" => "",
				"phone" => "",
			],
		],		
		"gallery" => []
	];

	public static function get()
	{
		return self::$body;
	}
}