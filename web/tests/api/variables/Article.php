<?php

Class Article {

	public static $body = [
	 	'id' => [],
		'title' => [],
		'sefName' => [],
		'subHeading' => [],
		'path' => [],
		'isAdvert' => [],
		'published' => [],
		'displayType' => [],
		'displayStyle' => [],
		'assignment' => [],
	];	

	public static function get()
	{
		return self::$body;
	}
}