<h1>{{ $title }}</h1>
<div id="dragon-table" class="card card-full-width">
	@if($can_create)
		<a href="{!! \Dragon\Support\Url::getAdminMenuLink($details_slug) !!}" class="button button-primary">Create</a>
	@endif
	@if($can_delete)
		@if($is_viewing_trashed && $can_restore)
		<button class="button button-danger" id="dragon-table-delete-button" data-action="restore">Restore Selected</button>
		@elseif (!$is_viewing_trashed)
		<button class="button button-danger" id="dragon-table-delete-button" data-action="delete">Delete Selected</button>
		@endif
	@endif
	@if($can_view_deleted)
		@if($is_viewing_trashed)
		<a href="{!! \Dragon\Support\Url::getCurrentUrl(['show_deleted' => 0]) !!}" class="button button-default">View Active</a>
		@else
		<a href="{!! \Dragon\Support\Url::getCurrentUrl(['show_deleted' => 1]) !!}" class="button button-default">View Deleted</a>
		@endif
	@endif
	@if(!empty($date_search_on_column))
	<div id="dragonfw-date-search" data-column-index="{{ $date_search_on_column }}" style="display:inline-block;float:right">
		<input type="text" id="date-min" name="date-min" placeholder="Minumum date">
		<input type="text" id="date-max" name="date-max" placeholder="Maximum date">
	</div>
	@endif
	<table id="data-table-wrapper">
		<thead>
			<tr>
			@foreach($columnHeaders as $dbCol => $header)
				<th class="dragonfw-col-data">{{ $header }}</th>
			@endforeach
			@foreach($rowActions as $actionName => $actionData)
				<th class="dragonfw-col-action">{{ $actionName }}</th>
			@endforeach
			</tr>
		</thead>
		<tbody
		data-route="{{ $route_name }}"
		data-delete-action="@namespaced(table_delete)"
		@if ($can_see_details)
			data-details-page="{!! $details_page !!}"
		@endif
		data-ajax="{!! admin_url('admin-ajax.php') !!}">
			@foreach($rows as $row)
			<tr data-row-id="{{ method_exists($row, 'getKeyName') ? $row->{$row->getKeyName()} : $row->id }}">
				@foreach($columnHeaders as $dbCol => $header)
					@if(in_array($dbCol, $display_raw_columns))
					<td>{!! $display_callback($row, $dbCol) !!}</td>
					@else
					<td>{{ $display_callback($row, $dbCol) }}</td>
					@endif
				@endforeach
				
				@foreach($rowActions as $actionName => $actionData)
					@if ($row_has_action($row, $actionName))
						@if (!empty($actionData['url_callback']))
							@php $link = $actionData['url_callback']($row); @endphp
						@else
							@php $link = \Dragon\Support\Url::getAdminMenuLink(
								$actionData['page_slug'],
								[$actionData['query_key'] => (method_exists($row, 'getKeyName') ? $row->{$row->getKeyName()} : $row->id)
							]);
							@endphp
						@endif
						<td><button class="action_button" data-link="{{ $link }}">
								<i class="dashicons {{ $actionData['icon_class'] }}"></i>
							</button>
						</td>
					@else
					<td>--</td>
					@endif
				@endforeach
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				@foreach($columnHeaders as $dbCol => $header)
					<th>{{ $header }}</th>
				@endforeach
				@foreach($rowActions as $actionName => $actionData)
					<th>{{ $actionName }}</th>
				@endforeach
			</tr>
		</tfoot>
	</table>
	@if (!empty($go_back_link()))
	<div><a href="{!! $go_back_link() !!}" class="button button-primary">Go Back</a></div>
	@endif
</div>
