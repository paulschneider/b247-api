<?php

Class Media {

	public static $body = [
	 	'filepath' => [],
		'alt' => [],
		'title' => [],
		'width' => [],
		'height' => [],
	];

	public static function get()
	{
		return self::$body;
	}
}