<h1>{{ $title }}</h1>
<div id="dragon-settings" class="card card-full-width">
	<form method="POST">
		@nonce
		<table class="form-table">
			<tr>
				@if (!$read_only)
				<td>
					<input name="save" type="submit" value="Save All" class="button button-primary" />
				</td>
				@endif
				@if (!empty($last_page))
				<td>
					<a href="{!! $last_page !!}">Go Back</a>
				</td>
				@endif
			</tr>
			@foreach($fields as $field)
				@if(is_string($field))
				<tr>
					<td colspan="2">
						<h2>{{ $field }}</h2>
					</td>
				</tr>
				@else
				<tr>
					<th scope="row">
						@if (!empty($field->getLabel()))
						<label for="{{ $field->getName() }}">
							{{ $field->getLabel() }} @if($field->isRequired())<i>(Required)</i>@endif
						</label>
						@endif
					</th>
					<td>
						@if ($read_only)
							{!! $field->readOnly()->render() !!}
						@else
							{!! $field->render() !!}
							@if (!empty($field->getDescription()))
								<p class="description">{!! $field->getDescription() !!}</p>
							@endif
							@error($field->getName())
							    <div class="notice notice-error">{{ $message }}</div>
							@enderror
						@endif
					</td>
				</tr>
				@endif
			@endforeach
			<tr>
				@if(!$read_only)
				<td>
					<input name="save" type="submit" value="Save All" class="button button-primary" />
				</td>
				@endif
				@if (!empty($last_page))
				<td>
					<a href="{!! $last_page !!}">Go Back</a>
				</td>
				@endif
			</tr>
		</table>
	</form>
</div>
