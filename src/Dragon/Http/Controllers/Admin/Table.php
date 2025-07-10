<?php

namespace Dragon\Http\Controllers\Admin;

use Dragon\Http\Controllers\AdminPageController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Dragon\Support\Url;
use Illuminate\Support\Facades\Cache;
use Dragon\Core\Config;
use Dragon\Support\User;
use Illuminate\Database\Eloquent\Collection;

abstract class Table extends AdminPageController {
	protected bool $canCreate = false;
	protected bool $canRead = false;
	protected bool $canUpdate = false;
	protected bool $canDelete = false;
	
	protected string $detailsSlug = "";
	protected string $view = "admin.table";
	protected ?string $requiredQueryParam = null;
	protected bool $hasSoftDeletes = false;
	protected bool $isViewingTrashed = false;
	protected array $displayRawColumns = [];
	
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
		$this->isViewingTrashed = (bool)$request->query->get('show_deleted', 0);
		$this->redirectIfMissingData($request);
		
		$rows = $this->getRows();
		$this->maybeAddTrash($rows);
		
		$this->loadPageAssets();
		return view($this->view, $this->makePageData($request, [
			'columnHeaders'	=> $this->headers,
			'rowActions'	=> $this->rowActions,
			'rows'			=> $rows,
			'details_slug'	=> $this->detailsSlug,
			'can_create'	=> $this->canCreate,
			'can_delete'	=> $this->canDelete,
			'can_see_details'	=> ($this->canUpdate || $this->canRead),
			'can_view_deleted'	=> $this->canViewDeleted(),
			'is_viewing_trashed'	=> $this->isViewingTrashed,
			'route_name'		=> static::$routeName,
			'display_raw_columns' => $this->displayRawColumns,
			'details_page'		=> Url::getAdminMenuLink($this->detailsSlug),
			'display_callback'	=> function($row, $column){return $this->getColumn($row, $column);},
			'row_has_action'	=> function($row, $actionName){return $this->rowHasAction($row, $actionName);},
			]));
	}
	
	public function delete(Request $request) {
		if ($this->canDelete === false || !$request->has('id')) {
			http_response_code(400);
		}
		
		$this->deleteRow($request->get('id'));
		http_response_code(200);
	}
	
	protected function getColumn($row, $column) : ?string {
		$out = $row->{$column};
		return is_array($out) ? implode(', ', $out) : $out;
	}
	
	protected function rowHasAction($row, string $actionName) : bool {
		return true;
	}
	
	protected function redirectIfMissingData(Request $request) {
		if (empty($this->requiredQueryParam)) {
			return;
		}
		
		$data = $request->get($this->requiredQueryParam);
		if (empty($data) || !$this->requiredQueryParamIsValid($data)) {
			wp_redirect(Url::getAdminMenuLink(static::$parentSlug));
			exit;
		}
		
		Cache::set(Config::prefix() . '_' . User::getUserId() . '_' . $this->requiredQueryParam, $data);
	}
	
	protected function requiredQueryParamIsValid(string $data) {
		return true;
	}
	
	protected function deleteRow(int $id) {
		//
	}
	
	protected function canViewDeleted() {
		return $this->hasSoftDeletes;
	}
	
	protected function maybeAddTrash(&$rows) {
		if (get_class($rows) === Builder::class) {
			if ($this->isViewingTrashed && $this->canViewDeleted()) {
				$rows = $rows->onlyTrashed()->get();
			} else {
				$rows = $rows->get();
			}
		}
		
		return $rows;
	}
	
	abstract protected function getRows();
}
