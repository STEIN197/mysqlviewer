<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<form action="" method="post">
			@csrf
			<p class="fs-20 fw-bold">@lang('admin.user.new')</p>
			<table class="table table-sm table-bordered table-light table-props">
				<tbody class="fs-20 fw-bold">
					<tr>
						<td colspan="2">@lang('admin.user.login')</td>
					</tr>
				</tbody>
				<tbody>
					@foreach ($columns as $col)
						<tr>
							<td>@lang("admin.user.columns.{$col}")</td>
							<td>
								<input required="" type="text" name="{{ $col }}"/>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<x-form-field type="button" name="login" :placeholder="__('admin.add')" class="btn btn-primary btn-sm"/>
		</form>
	</section>
</div>
