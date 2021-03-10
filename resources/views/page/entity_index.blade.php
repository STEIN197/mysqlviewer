<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<p class="fs-20 fw-bold">@lang("entity.type.{$type}.index")</p>
		<table class="table table-sm table-bordered table-light table-props">
			<thead class="thead-dark">
				<tr>
					<th>@lang('entity.column.name')</th>
					@foreach ($class::$_COLUMNS as $colName)
						<th>@lang("entity.type.{$type}.column.{$colName}")</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach ($data as $item)
					<tr>
						<td>{{ $item->id() }}</td>
						@foreach ($class::$_COLUMNS as $colName)
							<td>{{ $item->{$colName} }}</td>
						@endforeach
					</tr>
				@endforeach
			</tbody>
		</table>
	</section>
</div>
