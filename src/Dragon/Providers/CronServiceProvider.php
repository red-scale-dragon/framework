<?php

namespace Dragon\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Dragon\Support\Util;

class CronServiceProvider extends ServiceProvider
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
		if (!empty(config('cron.schedules'))) {
			add_filter('cron_schedules', function () { return config('cron.schedules'); });
		}
		
		foreach (config('cron.actions') as $hook => $data) {
			add_action(Util::namespaced($hook), $data['callback']);
			if (wp_next_scheduled(Util::namespaced($hook))) {
				continue;
			}
			
			$response = wp_schedule_event(time()+5, $data['schedule'], Util::namespaced($hook), [], true);
			if ($response instanceOf \WP_Error) {
				Log::info('Scheduling Cron: ' . Util::namespaced($hook));
				Log::info($response->get_error_messages());
			}
		}
	}
}
