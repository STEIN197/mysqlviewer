<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<p class="fs-20 fw-bold">@lang('admin.server.mysql.encodings.header')</p>
		<table class="table table-sm table-bordered table-light table-props">
			<thead class="thead-dark">
				<tr>
					<th>@lang('admin.server.mysql.encodings.name')</th>
					<th>@lang('admin.server.mysql.encodings.collations')</th>
					<th>@lang('admin.server.mysql.encodings.defaultCollation')</th>
					<th>@lang('admin.server.mysql.encodings.maxlen')</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($encodings as $encoding)
					<tr>
						<td>{{ $encoding->CHARACTER_SET_NAME }} ({{ $encoding->DESCRIPTION }})</td>
						<td>
							@foreach ($encoding->collations as $collation)
								{{ $collation->COLLATION_NAME }}<br/>
							@endforeach
						</td>
						<td>{{ $encoding->DEFAULT_COLLATE_NAME }}</td>
						<td>{{ $encoding->MAXLEN }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</section>
</div>
