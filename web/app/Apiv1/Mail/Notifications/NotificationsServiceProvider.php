<?php namespace Apiv1\Mail\Notifications;

use Illuminate\Support\ServiceProvider;

class NotificationsServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind(
        	'Apiv1\Mail\Notifications\NewAccountRegistrationEmail',
        	'Apiv1\Mail\Notifications\Mandrill\NewAccountRegistrationEmail'
        );

        $this->app->bind(
        	'Apiv1\Mail\Notifications\AccountPasswordChangedEmail',
        	'Apiv1\Mail\Notifications\Mandrill\AccountPasswordChangedEmail'
        );

        $this->app->bind(
        	'Apiv1\Mail\Notifications\ForgottenPasswordEmail',
        	'Apiv1\Mail\Notifications\Mandrill\ForgottenPasswordEmail'
        );

        $this->app->bind(
            'Apiv1\Mail\Notifications\PromotionRedemptionEmail',
            'Apiv1\Mail\Notifications\Mandrill\PromotionRedemptionEmail'
        );
    }

}