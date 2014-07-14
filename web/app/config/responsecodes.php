<?php

return [
	'contentLocated' => [
		'code' => 200,
		'message' => "Content successfully returned."
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
];