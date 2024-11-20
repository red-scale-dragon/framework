<?php

namespace Dragon\Providers;

use Illuminate\Support\ServiceProvider;

class TaxonomyServiceProvider extends ServiceProvider
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
		$taxonomies = config('taxonomies.tax');
		foreach ($taxonomies as $taxonomy) {
			add_action('init', [$taxonomy, 'init']);
			add_filter('term_updated_messages', [$taxonomy, 'updatedMessages']);
		}
	}
}
