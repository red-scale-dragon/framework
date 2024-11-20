<?php

namespace Dragon\Providers;

use Illuminate\Support\ServiceProvider;

class PostTypeServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		// ...
	}
	
	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		$items = config('post_types.post_types');
		foreach ($items as $item) {
			add_action('init', [$item, 'init']);
			add_filter('post_updated_messages', [$item, 'filterUpdatedMessages']);
			add_filter('bulk_post_updated_messages', [$item, 'filterBulkUpdatedMessages'], 10, 2);
		}
	}
}
