<?php

namespace Dragon\Http\Controllers\Admin;

use Dragon\Http\Controllers\AdminPageController;
use Illuminate\Http\Request;
use Dragon\Support\Url;

abstract class Table extends AdminPageController {
	protected bool $canCreate = false;
	protected bool $canRead = false;
	protected bool $canUpdate = false;
	protected bool $canDelete = false;
	
	protected string $detailsSlug = "";
	protected string $view = "admin.table";
	
	protected array $headers = [
		//
	];
	
	protected array $rowActions = [
	// 		'Transactions' => [
		// 			'icon_class'	=> 'dashicons-media-spreadsheet',
		// 			'page_slug'		=> 'dragonfw_dragonapp_transactions',
		// 			'query_key'		=> 'account_id',
		// 		],
	];
	
	protected static array $scripts = [
		'dataTables' => [
			'script' => '//cdn.datatables.net/v/dt/dt-2.3.2/b-3.2.3/b-colvis-3.2.3/b-html5-3.2.3/datatables.min.js',
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
			'style' => '//cdn.datatables.net/v/dt/dt-2.3.2/b-3.2.3/b-colvis-3.2.3/b-html5-3.2.3/datatables.min.css',
		],
	];
	
	public function show(Request $request) {
		$this->loadPageAssets();
		return view($this->view, $this->makePageData($request, [
			'columnHeaders'	=> $this->headers,
			'rowActions'	=> $this->rowActions,
			'rows'			=> $this->getRows(),
			'details_slug'	=> $this->detailsSlug,
			'can_create'	=> $this->canCreate,
			'can_delete'	=> $this->canDelete,
			'can_see_details'	=> ($this->canUpdate || $this->canRead),
			'route_name'	=> static::$routeName,
			'details_page'	=> Url::getAdminMenuLink($this->detailsSlug),
		]));
	}
	
	public function delete(Request $request) {
		if ($this->canDelete === false || !$request->has('id')) {
			http_response_code(400);
		}
		
		$this->deleteRow($request->get('id'));
		http_response_code(200);
	}
	
	protected function deleteRow(int $id) {
		//
	}
	
	abstract protected function getRows();
}
