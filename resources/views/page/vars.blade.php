<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<p class="fs-20 fw-bold">@lang('admin.server.mysql.vars.header')</p>
		<table class="table table-sm table-bordered table-light table-props">
			<thead class="thead-dark">
				<tr>
					<th>@lang('admin.server.mysql.vars.name')</th>
					<th>@lang('admin.server.mysql.vars.value')</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($variables as $row)
					<tr>
						<td>{{ $row->Variable_name }}</td>
						<td>{{ $row->Value }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</section>
</div>
