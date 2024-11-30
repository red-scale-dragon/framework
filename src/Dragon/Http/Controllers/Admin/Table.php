<?php

namespace Dragon\Http\Controllers\Admin;

use Dragon\Http\Controllers\AdminPageController;
use Illuminate\Http\Request;

abstract class Table extends AdminPageController {
	protected bool $canCreate = false;
	protected bool $canRead = false;
	protected bool $canUpdate = false;
	protected bool $canDelete = false;
	
	protected string $detailsSlug = "";
	
	protected array $headers = [
		//
	];
	
	protected static array $scripts = [
		'dataTables' => [
			'script' => '//cdn.datatables.net/2.1.8/js/dataTables.min.js',
		],
		'adminTable' => [
			'script' => 'admin/tables.js',
			'dependencies' => [
				'jquery', 'dataTables',
			],
		],
	];
	
	protected static array $styles = [
		'dataTables' => [
			'style' => '//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css',
		],
	];
	
	public function show(Request $request) {
		$this->loadPageAssets();
		return view('admin.table', $this->makePageData($request, [
			'columnHeaders'	=> $this->headers,
			'rows'			=> $this->getRows(),
			'details_slug'	=> $this->detailsSlug,
			'can_create'	=> $this->canCreate,
		]));
	}
	
	abstract protected function getRows();
}
