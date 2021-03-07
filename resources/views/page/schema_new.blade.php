<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<form action="" method="post">
			@csrf
			<p class="fs-20 fw-bold">@lang('admin.schema.new')</p>
			<table class="table table-sm table-bordered table-light table-props">
				<tbody>
					@foreach ($columns as $col)
						<tr>
							<td>@lang("admin.schema.columns.{$col}")</td>
							<td>
								@if (in_array($col, ['DEFAULT_CHARACTER_SET_NAME', 'DEFAULT_COLLATION_NAME']))
									<select name="{{ $col }}">
										@foreach (($col === 'DEFAULT_CHARACTER_SET_NAME' ? $charsets : $collations) as $value)
											<option value="{{ $value }}">{{ $value }}</option>
										@endforeach
									</select>
								@else
									<input required="" type="text" name="{{ $col }}"/>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<x-form-field type="button" name="login" :placeholder="__('admin.add')" class="btn btn-primary btn-sm"/>
		</form>
	</section>
</div>
