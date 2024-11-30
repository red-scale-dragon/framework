<?php

namespace Dragon\Providers;

use Illuminate\Support\ServiceProvider;
use Dragon\Assets\Asset;

class AssetsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    	$hook = is_admin() ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts';
    	add_action($hook, function () {
    		$this->loadAssets('global');
    		
    		if (is_admin()) {
    			$this->loadAssets('admin');
    		} else {
    			if (config('assets.frontend.enable_ajax', false)) {
    				Asset::enableFrontendAjax('jquery-core', false);
    			}
    			
    			$this->loadAssets('frontend');
    		}
    	});
    }
    
    private function loadAssets(string $key) {
    	$assets = config('assets.' . $key);
    	foreach ($assets['js'] as $name => $options) {
    		$deps = empty($options['dependencies']) ? [] : $options['dependencies'];
    		Asset::loadScript($name, $options['script'], $deps);
    	}
    	
    	foreach ($assets['css'] as $name => $options) {
    		$deps = empty($options['dependencies']) ? [] : $options['dependencies'];
    		Asset::loadCss($name, $options['style'], $deps);
    	}
    }
}
