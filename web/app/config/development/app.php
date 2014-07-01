<?php
return [

	/*
	|--------------------------------------------------------------------------
	| Custom Providers
	|--------------------------------------------------------------------------
	|
	| Custom providers that should only be available in the development environment
	| https://github.com/fzaninotto/Faker
	|
	|
	*/

	'providers' => append_config([
		'Clockwork\Support\Laravel\ClockworkServiceProvider' // https://github.com/itsgoingd/clockwork
	]),

	/*
	|--------------------------------------------------------------------------
	| Class Aliases
	|--------------------------------------------------------------------------
	|
	| Custom aliases for the development environment
	|
	*/

	'aliases' => append_config([		
		'Clockwork' 	  => 'Clockwork\Support\Laravel\Facade'
	]),

	/*
	|--------------------------------------------------------------------------
	| Fake It
	|--------------------------------------------------------------------------
	|
	| Whether we want to override the form inputs with faked data user Faker
	| https://github.com/fzaninotto/Faker
	|
	|
	*/

	'fakeIt' => true,

	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| Dev mode debug status
	|
	*/

	'debug' => true,
];