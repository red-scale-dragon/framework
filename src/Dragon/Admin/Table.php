<?php

namespace Dragon\Admin;

use Illuminate\Http\Request;

class Table {
	public static function handleTableRowDelete() {
		$routeName = request('route');
		if (empty($routeName)) {
			echo json_encode([
				'success' => false,
			]);
			wp_die();
		}
		
		$request = Request::capture();
		$url = route($routeName, $request->all(), false);
		
		$req = Request::create(
			$url,
			'DELETE',
			$request->all(),
			$request->cookies->all(),
			$request->files->all(),
			$request->server->all()
		);
		
		$res = app()->handle($req);
		echo json_encode([
			'success' => ($res->getStatusCode() === 200)
		]);
		
		wp_die();
	}
}
