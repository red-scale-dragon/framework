<?php

namespace Dragon\Tests\Unit\Support;

use Tests\TestCase;
use Dragon\Support\User;

class UserTest extends TestCase {
	public function testCanSeeIfLoggedIn() {
		$id = $this->factory->user->create();
		
		$this->assertFalse(User::isLoggedIn());
		wp_set_current_user($id);
		$this->assertTrue(User::isLoggedIn());
	}
	
	public function testCanGetUser() {
		$id = $this->factory->user->create();
		
		$this->assertSame($id, User::get($id)->ID);
		
		wp_set_current_user($id);
		$this->assertSame($id, User::get()->ID);
	}
	
	public function testForceLogout() {
		$id = $this->factory->user->create();
		
		wp_set_current_user($id);
		$this->assertTrue(User::isLoggedIn());
		
		User::logout();
		$this->assertFalse(User::isLoggedIn());
	}
	
	public function testCanGetUserId() {
		$id = $this->factory->user->create();
		
		wp_set_current_user($id);
		$this->assertSame($id, User::getUserId());
	}
	
	public function testCanGetUserEmail() {
		$id = $this->factory->user->create(['user_email' => 'test@example.com']);
		
		$this->assertSame('test@example.com', User::getUserEmail($id));
		
		wp_set_current_user($id);
		$this->assertSame('test@example.com', User::getUserEmail());
	}
	
	public function testCanGetUsername() {
		$id = $this->factory->user->create(['user_nicename' => 'test']);
		
		$this->assertSame('test', User::getUsername($id));
		
		wp_set_current_user($id);
		$this->assertSame('test', User::getUsername());
	}
	
	public function testCanCheckIfAdmin() {
		$id = $this->factory->user->create();
		
		$this->assertFalse(User::isAdmin());
		$this->assertFalse(User::isAdmin($id));
		
		User::setRole($id, User::ROLE_ADMIN);
		
		$this->assertTrue(User::isAdmin($id));
		
		wp_set_current_user($id);
		$this->assertTrue(User::isAdmin());
	}
	
	public function testUserHasCapability() {
		$id = $this->factory->user->create();
		
		$this->assertFalse(User::can('manage_options'));
		$this->assertFalse(User::can('manage_options', $id));
		
		User::setRole($id, User::ROLE_ADMIN);
		
		$this->assertTrue(User::can('manage_options', $id));
		
		wp_set_current_user($id);
		$this->assertTrue(User::can('manage_options'));
	}
	
	public function testCanGetUsersFirstRole() {
		$id = $this->factory->user->create();
		
		$this->assertSame(null, User::getRole());
		$this->assertSame('subscriber', User::getRole($id));
		
		User::setRole($id, User::ROLE_ADMIN);
		
		$this->assertSame('administrator', User::getRole($id));
		
		wp_set_current_user($id);
		$this->assertSame('administrator', User::getRole());
	}
	
	public function testCanCheckIfUserHasARole() {
		$id = $this->factory->user->create();
		
		$this->assertFalse(User::hasRole('subscriber'));
		$this->assertTrue(User::hasRole('subscriber', $id));
	}
	
	public function testCanGetUsersRolesList() {
		$id = $this->factory->user->create();
		
		$this->assertSame([], User::getRoles());
		$this->assertSame(['subscriber'], User::getRoles($id));
		
		User::setRole($id, User::ROLE_ADMIN);
		$this->assertSame(['administrator'], User::getRoles($id));
	}
	
	public function testCanGetUsersCapabilitiesList() {
		$id = $this->factory->user->create();
		
		$this->assertSame([], User::getCapabilities());
		$this->assertSame(['read', 'level_0', 'subscriber'], User::getCapabilities($id));
		
		User::setRole($id, User::ROLE_ADMIN);
		$this->assertCount(63, User::getCapabilities($id));
	}
	
	public function testCanGetUserMeta() {
		$id = $this->factory->user->create();
		
		User::setMeta('test', 'blah', $id);
		$this->assertSame('blah', User::getMeta('test', null, $id));
		
		User::deleteMeta('test', $id);
		$this->assertNull(User::getMeta('test', null, $id));
	}
	
	public function testCanGetAllUserMeta() {
		$id = $this->factory->user->create();
		
		User::setMeta('test', 'blah', $id);
		$this->assertNotEmpty(User::getAllMeta($id));
	}
	
	public function testCanGetAllUserIds() {
		$id1 = $this->factory->user->create();
		$id2 = $this->factory->user->create();
		
		$this->assertSame([1, $id1, $id2], User::getUserIds());
	}
	
	public function testCanGetUserOption() {
		$id = $this->factory->user->create();
		
		$this->assertSame(null, User::getUserOption('test_option', null, $id));
		User::setUserOption('test_option', 'blah', $id);
		$this->assertSame('blah', User::getUserOption('test_option', null, $id));
	}
	
	public function testCanLoginAsOtherUser() {
		$id = $this->factory->user->create();
		
		wp_set_current_user(1);
		$this->assertNotSame(1, $id);
		$this->assertSame(1, User::getUserId());
		
		User::loginAs($id);
		$this->assertSame($id, User::getUserId());
	}
	
	public function testCanRegisterNewUser() {
		$id = User::register('test', 'testpass', 'test@example.com');
		$this->assertIsInt($id);
		
		$error = User::register('test', 'testpass', 'test');
		$this->assertInstanceOf(\WP_Error::class, $error);
	}
}
