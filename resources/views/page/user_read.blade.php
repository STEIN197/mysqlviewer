<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<form action="" method="post">
			@csrf

			@if (@$success)
				<p class="alert alert-success pd-10">@lang('admin.user.success')</p>
			@endif

			<input type="hidden" name="user" value="{{ $name }}"/>
			<p class="fs-20 fw-bold">{{ $name }}</p>
			<table class="table table-sm table-bordered table-light table-props">
				<tbody class="fs-20 fw-bold">
					<tr>
						<td colspan="2">@lang('admin.user.login')</td>
					</tr>
				</tbody>
				<tbody>
					@foreach ($login as $col => $value)
						<tr>
							<td>@lang("admin.user.columns.{$col}")</td>
							<td>
								<input type="text" name="{{ $col }}" value="{{ $col === 'Password' ? '' : $value }}"/>
							</td>
						</tr>
					@endforeach
				</tbody>
				<tbody class="fs-20 fw-bold">
					<tr>
						<td colspan="2">@lang('admin.user.limits')</td>
					</tr>
				</tbody>
				<tbody>
					@foreach ($limits as $col => $value)
						<tr>
							<td>@lang("admin.user.columns.{$col}")</td>
							<td>
								<input type="text" name="{{ $col }}" value="{{ $value }}"/>
							</td>
						</tr>
					@endforeach
				</tbody>
				<tbody class="fs-20 fw-bold">
					<tr>
						<td colspan="2">@lang('admin.user.privileges')</td>
					</tr>
				</tbody>
				<tbody>
					@foreach ($privileges as $col => $value)
						<tr>
							<td>@lang("admin.user.columns.{$col}")</td>
							<td>
								<input type="checkbox" name="{{ $col }}" value="{{ $value }}" @if ($value === 'Y') checked="" @endif/>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<x-form-field type="button" name="login" :placeholder="__('admin.user.submit')" class="btn btn-primary btn-sm"/>
		</form>
	</section>
</div>
