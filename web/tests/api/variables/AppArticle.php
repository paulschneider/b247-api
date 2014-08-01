<?php

Class AppArticle {

	public static $body = [
	 	'channel' => [],
		'adverts' => [],
		'navigation' => [],
		'html' => [],
	];

	public static function get()
	{
		return self::$body;
	}
}