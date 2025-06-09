<h1>{{ $title }}</h1>
<div id="dragon-log" class="card card-full-width" style="max-width:unset">
	<form method="POST">
		@nonce
		<table class="form-table">
			<tr>
				<td>
					<input name="save" type="submit" value="Clear" class="button button-primary" />
				</td>
			</tr>
			<tr>
				<td>{!! $log->render() !!}</td>
			</tr>
			<tr>
				<td>
					<input name="save" type="submit" value="Clear" class="button button-primary" />
				</td>
			</tr>
		</table>
	</form>
</div>
