<?php

Event::listen('apiFire', function($message)
{
	App::abort(404, $message);
});