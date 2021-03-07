<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<p class="fs-20 fw-bold">{{ $schema['SCHEMA_NAME'] }}</p>
		<table class="table table-sm table-bordered table-light table-props">
			<thead class="thead-dark">
				<tr>
					<th>@lang('admin.table.name')</th>
					<th>@lang('admin.table.data')</th>
					<th>@lang('admin.table.structure')</th>
					<th>@lang('admin.table.add')</th>
					<th>@lang('admin.table.truncate')</th>
					<th>@lang('admin.table.delete')</th>
					<th>@lang('admin.table.rows')</th>
					<th>@lang('admin.table.type')</th>
					<th>@lang('admin.table.collation')</th>
					<th>@lang('admin.table.size')</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($tables as $row)
					<tr>
						<td>{{ $row->TABLE_NAME }}</td>
						<td>
							<a href="{{ route('admin.table.rows', ['id' => $schema['SCHEMA_NAME'], 'name' => $row->TABLE_NAME]) }}">@lang('admin.table.data')</a>
						</td>
						<td>
							<a href="">@lang('admin.table.structure')</a>
						</td>
						<td>
							<a href="">@lang('admin.table.add')</a>
						</td>
						<td>
							<a href="{{ route('admin.table.truncate', ['id' => $row->TABLE_SCHEMA, 'name' => $row->TABLE_NAME]) }}">@lang('admin.table.truncate')</a>
						</td>
						<td>
							<a href="{{ route('admin.delete.table', ['id' => $row->TABLE_NAME, 'schema' => $row->TABLE_SCHEMA]) }}">@lang('admin.table.delete')</a>
						</td>
						<td>{{ $row->TABLE_ROWS }}</td>
						<td>{{ $row->ENGINE }}</td>
						<td>{{ $row->TABLE_COLLATION }}</td>
						<td>{{ ($row->DATA_LENGTH + $row->INDEX_LENGTH) / 1024 / 1024 }}MB</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<a href="{{ route('admin.new.table', ['schema' => $schema['SCHEMA_NAME']]) }}" class="btn btn-primary btn-sm">@lang('admin.add')</a>
	</section>
</div>
