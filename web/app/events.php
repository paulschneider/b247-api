<?php

Event::listen('apiFire', function($message)
{
    exit($message);
});