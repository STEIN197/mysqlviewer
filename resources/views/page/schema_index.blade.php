<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<p class="fs-20 fw-bold">@lang('admin.schemas.header')</p>
		<table class="table table-sm table-bordered table-light table-props">
			<thead class="thead-dark">
				<tr>
					<th>@lang('admin.schemas.name')</th>
					<th>@lang('admin.schemas.charset')</th>
					<th>@lang('admin.schemas.collation')</th>
					<th>@lang('admin.delete')</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($schemas as $row)
					<tr>
						<td>{{ $row->SCHEMA_NAME }}</td>
						<td>{{ $row->DEFAULT_CHARACTER_SET_NAME }}</td>
						<td>{{ $row->DEFAULT_COLLATION_NAME }}</td>
						<td>
							<a href="{{ route('admin.delete.schema', ['name' => $row->SCHEMA_NAME]) }}">@lang('admin.delete')</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<a href="{{ route('admin.new.schema') }}" class="btn btn-primary btn-sm">@lang('admin.add')</a>
	</section>
</div>
