<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<form action="" method="post">
			@csrf
			<p class="fs-20 fw-bold">{{ $data['SCHEMA_NAME'] }}</p>
			<table class="table table-sm table-bordered table-light table-props">
				<tbody>
					@foreach ($data as $col => $value)
						<tr>
							<td>@lang("admin.schema.columns.{$col}")</td>
							<td>
								@if (in_array($col, ['DEFAULT_CHARACTER_SET_NAME', 'DEFAULT_COLLATION_NAME']))
									<select name="{{ $col }}" value="{{ $value }}">
										@foreach (($col === 'DEFAULT_CHARACTER_SET_NAME' ? $charsets : $collations) as $v)
											<option value="{{ $v }}" @if ($v === $value) selected="" @endif>{{ $v }}</option>
										@endforeach
									</select>
								@else
									<input required="" type="text" name="{{ $col }}" value="{{ $value }}" disabled=""/>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<x-form-field type="button" name="login" :placeholder="__('admin.submit')" class="btn btn-primary btn-sm"/>
		</form>
	</section>
</div>
