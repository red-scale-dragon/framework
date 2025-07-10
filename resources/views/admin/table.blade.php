<h1>{{ $title }}</h1>
<div id="dragon-table" class="card card-full-width">
	@if($can_create)
		<a href="{!! \Dragon\Support\Url::getAdminMenuLink($details_slug) !!}" class="button button-primary">Create</a>
	@endif
	@if($can_delete)
		<button class="button button-danger" id="dragon-table-delete-button">Delete Selected</button>
	@endif
	@if($can_view_deleted)
		@if($is_viewing_trashed)
		<a href="{!! \Dragon\Support\Url::getCurrentUrl(['show_deleted' => 0]) !!}" class="button button-default">View Active</a>
		@else
		<a href="{!! \Dragon\Support\Url::getCurrentUrl(['show_deleted' => 1]) !!}" class="button button-default">View Deleted</a>
		@endif
	@endif
	<table id="data-table-wrapper">
		<thead>
			<tr>
			@foreach($columnHeaders as $dbCol => $header)
				<th>{{ $header }}</th>
			@endforeach
			@foreach($rowActions as $actionName => $actionData)
				<th>{{ $actionName }}</th>
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
			<tr data-row-id="{{ $row->{$row->getKeyName()} }}">
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
							@php $link = \Dragon\Support\Url::getAdminMenuLink($actionData['page_slug'], [$actionData['query_key'] => $row->{$row->getKeyName()}]); @endphp
						@endif
						<td><button
							onclick="window.location='{{ $link }}'">
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
	</table>
</div>
