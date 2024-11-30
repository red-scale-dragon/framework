@if(!empty($notice))
	{!! $notice !!}
@endif
<h1>{{ $title }}</h1>
<div id="dragon-settings" class="card card-full-width">
	<form method="POST">
		@nonce
		<table class="form-table">
			<tr>
				<td>
					<input name="save" type="submit" value="Save All" class="button button-primary" />
				</td>
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
						<label for="{{ $field->getName() }}">
							{{ $field->getLabel() }} @if($field->isRequired())<i>(Required)</i>@endif
						</label>
					</th>
					<td>
						{!! $field->render() !!}
						@error($field->getName())
						    <div class="notice notice-error">{{ $message }}</div>
						@enderror
					</td>
				</tr>
				@endif
			@endforeach
			<tr>
				<td>
					<input name="save" type="submit" value="Save All" class="button button-primary" />
				</td>
			</tr>
		</table>
	</form>
</div>
