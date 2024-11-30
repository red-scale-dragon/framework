<h1>{{ $title }}</h1>
<div id="dragon-table" class="card card-full-width">
	@if($can_create)
		<a href="{!! \Dragon\Support\Url::getAdminMenuLink($details_slug) !!}" class="button button-primary">Create</a>
	@endif
	<table id="data-table-wrapper">
		<thead>
			<tr>
			@foreach($columnHeaders as $dbCol => $header)
				<th>{{ $header }}</th>
			@endforeach
			</tr>
		</thead>
		<tbody>
			@foreach($rows as $row)
			<tr>
				@foreach($columnHeaders as $dbCol => $header)
					<td>{{ $row->{$dbCol} }}</td>
				@endforeach
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
