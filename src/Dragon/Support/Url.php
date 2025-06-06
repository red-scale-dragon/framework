<?php

namespace Dragon\Support;

class Url {
	public static function isRestRequest() : bool {
		return defined('REST_REQUEST') && REST_REQUEST;
	}
	
	public static function isUrl(string $text, string $protocolStartsWith = 'http') : bool {
		return strpos($text, $protocolStartsWith) === 0;
	}
	
	public static function getBySlug(string $page, array $additionalQuery = []) : string {
		$page = get_page_by_path($page);
		$url = get_permalink($page);
		
		if (!empty($additionalQuery)) {
			$url = static::changeQuery($url, $additionalQuery);
		}
		
		return $url;
	}
	
	public static function getProductBySlug(string $page) : ?string {
		$page = get_page_by_path($page, OBJECT, 'product');
		$link = get_permalink($page);
		return $link === false ? null : $link;
	}
	
	public static function getAdminMenuLink($slug, array $additionalQuery = []) : string {
		$link = menu_page_url(Util::namespaced($slug), false);
		if (empty($link)) {
			$link = url()->to('/wp-admin/admin.php?page=' . $slug);
		}
		
		$append = [];
		if (!empty($additionalQuery)) {
			foreach ($additionalQuery as $key => $val) {
				$append[] = $key . '=' . $val;
			}
		}
		
		$finished = empty($append) ? '' : '&' . implode('&', $append);
		return $link . $finished;
	}
	
	public static function getCurrentUrl(array $appendedQuery = []) : string {
		$url = url()->current();
		if (!empty($appendedQuery)) {
			return static::changeQuery($url, $appendedQuery);
		}
		
		return $url;
	}
	
	private static function changeQuery(string $url, array $appendedQuery) : string {
		$newQuery = static::parseQuery($url, $appendedQuery);
		
		foreach ($appendedQuery as $key => $val) {
			$newQuery[] = $key . '=' . $val;
		}
		
		$newQuery = implode('&', $newQuery);
		$parts = explode('?', $url);
		$parts[1] = $newQuery;
		return implode('?', $parts);
	}
	
	private static function parseQuery(string $url, array $skipVars) : array {
		$newQuery = [];
		$parsedQuery = parse_url($url, PHP_URL_QUERY);
		if (empty($parsedQuery)) {
			return [];
		}
		$query = explode('&', $parsedQuery);
		foreach ($query as $item) {
			list($key, $val) = explode('=', $item);
			if (array_key_exists($key, $skipVars)) {
				continue;
			}
			
			$newQuery[] = $key . '=' . $val;
		}
		
		return $newQuery;
	}
}
