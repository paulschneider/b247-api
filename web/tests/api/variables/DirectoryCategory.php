<?php

Class DirectoryCategory {

	public static $body = [
	 	'channel' => [],
		'adverts' => [],
		'map' => [],
		'articles' => [],
		'totalArticles' => [],
	];

	public static function get()
	{
		return self::$body;
	}
}