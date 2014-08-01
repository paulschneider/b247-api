<?php

Class ArticleAssignmentChannel {

	public static $body = [
		'id' => '',
		'name' => '',
		'sefName' => '',
		'path' => ''
	];

	public static function get()
	{
		return self::$body;
	}	

}