<?php

namespace Dragon\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Dragon\Support\Util;
use Dragon\Admin\Notice;

class ValidatesNonce
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    	$request->attributes->add([
    		'notice' => null,
    		'nonce_invalid' => false,
    	]);
    	
    	if ($request->getMethod() !== 'POST') {
    		return $next($request);
    	}
    	
    	$nonce = $request->post(Util::namespaced('nonce'));
    	if (!wp_verify_nonce($nonce, Util::namespaced('nonce'))) {
    		$request->attributes->add([
    			'notice' => Notice::error(Notice::ERROR_INVALID_NONCE),
    			'nonce_invalid' => true,
    		]);
    	}
    	
        return $next($request);
    }
}
