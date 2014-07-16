<?php

return [
	'contentLocated' => [
		'code' => 200,
		'message' => "Content successfully returned."
	],	
	'created' => [
		'code' => 201,
		'message' => "Resource successfully created."
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
	'unprocessable' => [
		'code' => 422,
		'message' => "The request could not be processed due to errors."
	],
	'failedDependency' => [
		'code' => 424,
		'message' => "Request failed to satisfy endpoint requirements."
	],
	'notAcceptable' => [
		'code' => 442,
		'message' => "Invalid query parameter combination."
	],
	'serverError' => [
		'code' => 500,
		'message' => "There was an error processing the request."
	],
	'notImplemented' => [
		'code' => 501,
		'message' => "Method action not available. Please refer to the documentation for the use of this endpoint."
	],
];