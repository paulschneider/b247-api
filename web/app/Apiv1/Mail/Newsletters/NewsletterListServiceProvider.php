<?php namespace Apiv1\Mail\Newsletters;

use Illuminate\Support\ServiceProvider;

class NewsletterListServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind(
        	'Apiv1\Mail\Newsletters\NewsletterList',
        	'Apiv1\Mail\Newsletters\Mailchimp\NewsletterList'
        );
    }

}