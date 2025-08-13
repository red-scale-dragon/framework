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
	protected bool $canRestore = false;
	
	protected string $detailsSlug = "";
	protected string $view = "admin.table";
	protected ?string $requiredQueryParam = null;
	protected bool $hasSoftDeletes = false;
	protected bool $isViewingTrashed = false;
	protected string $dateSearchOnHeader = '';
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
		'pdf-make' => [
			'script' => '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js',
		],
		'pdf-make-fonts' => [
			'script' => '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js',
		],
		'luxon' => [
			'script' => '//cdnjs.cloudflare.com/ajax/libs/luxon/3.7.1/luxon.min.js',
		],
		'dataTables' => [
			'script' => '//cdn.datatables.net/v/dt/dt-2.3.2/b-3.2.4/b-colvis-3.2.4/b-html5-3.2.4/cr-2.1.1/date-1.5.6/sp-2.3.4/sl-3.0.1/datatables.min.js',
			'dependencies' => [
				'pdf-make', 'pdf-make-fonts', 'luxon',
			],
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
			'style' => '//cdn.datatables.net/v/dt/dt-2.3.2/b-3.2.4/b-colvis-3.2.4/b-html5-3.2.4/cr-2.1.1/date-1.5.6/sp-2.3.4/sl-3.0.1/datatables.min.css',
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
			'can_restore'	=> $this->canRestore,
			'can_see_details'	=> ($this->canUpdate || $this->canRead),
			'can_view_deleted'	=> $this->canViewDeleted(),
			'is_viewing_trashed'	=> $this->isViewingTrashed,
			'route_name'			=> static::$routeName,
			'display_raw_columns' 	=> $this->displayRawColumns,
			'date_search_on_column'	=> $this->getColumnIndex($this->dateSearchOnHeader),
			'details_page'		=> Url::getAdminMenuLink($this->detailsSlug),
			'display_callback'	=> function($row, $column){return $this->getColumn($row, $column);},
			'row_has_action'	=> function($row, $actionName){return $this->rowHasAction($row, $actionName);},
			'go_back_link'		=> function(){return $this->getGoBackLink();},
			]));
	}
	
	public function delete(Request $request) {
		if ($this->canDelete === false || !$request->has('id')) {
			http_response_code(400);
		}
		
		$this->deleteRow($request);
		http_response_code(200);
	}
	
	protected function getColumnIndex(string $headerName) : ?int {
		if (empty($this->headers[$headerName])) {
			return null;
		}
		
		return array_flip(array_keys($this->headers))[$headerName];
	}
	
	protected function getGoBackLink() : ?string {
		return null;
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
	
	protected function deleteRow(Request $request) {
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
