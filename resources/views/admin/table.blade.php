<h1>{{ $title }}</h1>
<div id="dragon-table" class="card card-full-width">
	@if($can_create)
		<a href="{!! \Dragon\Support\Url::getAdminMenuLink($details_slug) !!}" class="button button-primary">Create</a>
	@endif
	@if($can_delete)
		<button class="button button-danger" id="dragon-table-delete-button">Delete Selected</button>
	@endif
	<table id="data-table-wrapper">
		<thead>
			<tr>
			@foreach($columnHeaders as $dbCol => $header)
				<th>{{ $header }}</th>
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
					<td>{{ $row->{$dbCol} }}</td>
				@endforeach
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
