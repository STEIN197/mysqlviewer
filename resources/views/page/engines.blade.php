<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<p class="fs-20 fw-bold">@lang('admin.server.mysql.engines.header')</p>
		<table class="table table-sm table-bordered table-light table-props">
			<thead class="thead-dark">
				<tr>
					<th>@lang('admin.server.mysql.engines.name')</th>
					<th>@lang('admin.server.mysql.engines.support')</th>
					<th>@lang('admin.server.mysql.engines.desc')</th>
					<th>@lang('admin.server.mysql.engines.transactions')</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($engines as $row)
					<tr>
						<td>{{ $row->ENGINE }}</td>
						<td class="text-center">
							@if (PDOWrapper::toBool($row->SUPPORT))
								<i class="fas fa-check-circle c-green"></i>
							@elseif (PDOWrapper::toBool($row->SUPPORT) !== null)
								<i class="fas fa-times c-red"></i>
							@else
								{{ $row->SUPPORT }}
							@endif
						</td>
						<td>{{ $row->COMMENT }}</td>
						<td class="text-center">
							@if (PDOWrapper::toBool($row->TRANSACTIONS))
								<i class="fas fa-check-circle c-green"></i>
							@else
								<i class="fas fa-times c-red"></i>
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</section>
</div>
