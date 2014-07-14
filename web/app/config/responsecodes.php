<?php

return [
	'contentLocated' => [
		'code' => 200,
		'message' => "Content successfully returned."
	],	
	'noContent' => [
		'code' => 206,
		'message' => "Call successful however there is Nothing to return."
	],		
	'badRequest' => [
		'code' => 400,
		'message' => "Invalid request. Please refer to the documentation for the use of this endpoint."
	],	
	'notFound' => [
		'code' => 404,
		'message' => "The requested content item or resource could not be found."
	],
	'insufficientArguments' => [
		'code' => 412,
		'message' => "Not enough arguments."
	],
	'expectationFailed' => [
		'code' => 417,
		'message' => "Supplied arguments did not meet the expectations of the endpoint."
	],
	'failedDependency' => [
		'code' => 424,
		'message' => "Request failed to satisfy endpoint requirements."
	],
	'notAcceptable' => [
		'code' => 442,
		'message' => "Invalid query parameter combination."
	],
	'notImplemented' => [
		'code' => 501,
		'message' => "Method action not available. Please refer to the documentation for the use of this endpoint."
	],
];