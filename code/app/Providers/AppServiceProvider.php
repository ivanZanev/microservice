<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		$this->app->bind('Twilio\Rest\Client', function($app) {
			$sid    = config('twilio.account_sid');
			$token  = config('twilio.auth_token');
			$twilioClient = new \Twilio\Rest\Client($sid, $token);

			return $twilioClient;
		});

		$this->app->bind('App\Services\Twilio', function($app) {
			$client = app()->make('Twilio\Rest\Client');
			$settings = [];
			$settings['from'] = config('twilio.from');

			$service = new \App\Services\Twilio($client, $settings);
			
			return $service;
		});
    }
}
