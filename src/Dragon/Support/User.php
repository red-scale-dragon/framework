<?php

namespace Dragon\Support;

class User {
	const USER_KEY_BASE = 'dragon.user_data';
	const ROLE_ADMIN = 'administrator';
	
	public static function isLoggedIn() : bool {
		return static::get()->exists();
	}
	
	public static function get(?int $userId = null) : \WP_User {
		$userId = empty($userId) ? get_current_user_id() : $userId;
		return new \WP_User($userId);
	}
	
	public static function logout() {
		wp_logout();
		wp_redirect(wp_login_url());
	}
	
	public static function getUserId() : int {
		return static::get()->ID;
	}
	
	public static function getUserEmail(?int $userId = null) : string {
		return static::get($userId)->user_email;
	}
	
	public static function getUsername(?int $userId = null) : string {
		return static::get($userId)->user_nicename;
	}
	
	public static function isAdmin(?int $userId = null) : bool {
		$roles = static::getRoles($userId);
		return is_array($roles) && in_array(static::ROLE_ADMIN, $roles);
	}
	
	public static function can(string $capability, ?int $userId = null) : bool {
		return user_can(static::get($userId), $capability);
	}
	
	public static function getRole(?int $userId = null) : ?string {
		$roles = static::getRoles($userId);
		return is_array($roles) && !empty($roles[0]) ? $roles[0] : null;
	}
	
	public static function hasRole(string $role, ?int $userId = null) : bool {
		$roles = static::getRoles($userId);
		return in_array($role, $roles);
	}
	
	public static function setRole(int $userId, string $role) {
		static::get($userId)->set_role($role);
	}
	
	public static function getRoles(?int $userId = null) : array {
		$user = static::get($userId);
		return !empty($user->roles) ? $user->roles : [];
	}
	
	public static function getCapabilities(?int $userId = null) : array {
		$user = static::get($userId);
		if (empty($user)) {
			return [];
		}
		
		return !empty($user->allcaps) ? array_keys($user->allcaps) : [];
	}
	
	public static function getMeta(?string $key = null, $default = null, ?int $userId = null) {
		$userId ??= static::getUserId();
		$data = get_user_meta($userId, $key, true);
		return empty($data) ? $default : $data;
	}
	
	public static function getAllMeta(int $userId) : array {
		return get_user_meta($userId);
	}
	
	public static function setMeta(string $key, $value, ?int $userId = null) {
		$userId ?? static::getUserId();
		update_user_meta($userId, $key, $value);
	}
	
	public static function deleteMeta(string $key, ?int $userId = null) {
		$userId ??= static::getUserId();
		delete_user_meta($userId, $key);
	}
	
	public static function getUserIds(array $args = []) : array {
		$ids = [];
		$users = get_users($args);
		foreach ($users as $user) {
			$ids[] = $user->ID;
		}
		
		return $ids;
	}
	
	public static function redirectIfNotLoggedIn() {
		if (static::isLoggedIn() === false) {
			auth_redirect();
		}
	}
	
	public static function getUserOption(string $key, $default = null, ?int $userId = null) {
		$userId ??= static::getUserId();
		$key = static::getKeyNameForUser($key, $userId);
		return get_option($key, $default);
	}
	
	public static function setUserOption(string $key, $data, ?int $userId = null) {
		$userId ??= static::getUserId();
		$key = static::getKeyNameForUser($key, $userId);
		update_option($key, $data);
	}
	
	public static function loginAs(int $userId) {
		wp_clear_auth_cookie();
		wp_set_current_user($userId);
		wp_set_auth_cookie($userId);
	}
	
	public static function register(string $username, string $password, string $email) {
		return wp_create_user($username, $password, $email);
	}
	
	private static function getKeyNameForUser(string $key, ?int $userId = null) : string {
		$userId ??= static::getUserId();
		return Util::namespaced($userId . '_' . $key);
	}
}
