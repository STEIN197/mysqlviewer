<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<p class="fs-20 fw-bold">{{ $table }}</p>
		<table class="table table-sm table-bordered table-light table-props">
			<thead class="thead-dark">
				<tr>
					@if ($primary)
						<th style="width:1px">@lang('admin.table.actions')</th>
					@endif
					@foreach ($columns as $col => $value)
						<th>{{ $col }}</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach ($rows as $row)
					<tr>
						@if ($primary)
							<td style="width:1px">
								<a href="">@lang('admin.table.change')</a> | <a href="">@lang('admin.table.delete')</a>
							</td>
						@endif
						@foreach ($columns as $col => $value)
							<th>{{ $row->{$col} }}</th>
						@endforeach
					</tr>
				@endforeach
			</tbody>
		</table>
		<a href="" class="btn btn-primary btn-sm">@lang('admin.add')</a>
	</section>
</div>
