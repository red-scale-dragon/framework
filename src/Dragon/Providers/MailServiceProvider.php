<?php

namespace Dragon\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use Dragon\Mail\WpMailTransport;

class MailServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void {
		// ...
	}
	
	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void {
		Mail::extend('wp_mail', function (array $config = []) {
			return new WpMailTransport();
		});
	}
}
