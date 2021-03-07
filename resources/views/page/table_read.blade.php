<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<form action="" method="post">
			@csrf
			<p class="fs-20 fw-bold">{{ $data['TABLE_NAME'] }}</p>
			<p class="fs-18 fw-bold">@lang('admin.table.main')</p>
			<table class="table table-sm table-bordered table-light table-props">
				<tbody>
					<tr>
						<td>@lang('admin.table.name')</td>
						<td>
							<input type="text" name="TABLE_NAME" value="{{ $data['TABLE_NAME'] }}"/>
						</td>
					</tr>
				</tbody>
			</table>
			<p class="fs-18 fw-bold">@lang('admin.table.columns')</p>
			<table class="table table-sm table-bordered table-light table-props">
				<thead>
					<tr>
						<th>@lang('admin.actions')</th>
						<th>@lang('admin.name')</th>
						<th>@lang('admin.table.type')</th>
						<th>@lang('admin.table.collation')</th>
						<th>NULL</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($columns as $name => $value)
						<tr>
							<td>
								<a href="">@lang('admin.edit')</a>
								|
								<a href="">@lang('admin.delete')</a>
							</td>
							<td>{{ $value->COLUMN_NAME }}</td>
							<td>{{ $value->DATA_TYPE }}</td>
							<td>{{ $value->COLLATION_NAME }}</td>
							<td>{{ $value->IS_NULLABLE }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<x-form-field type="button" name="login" :placeholder="__('admin.column.add')" class="btn btn-primary btn-sm"/>
			<x-form-field type="button" name="login" :placeholder="__('admin.submit')" class="btn btn-primary btn-sm"/>
		</form>
	</section>
</div>
