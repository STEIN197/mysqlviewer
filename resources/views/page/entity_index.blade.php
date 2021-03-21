<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<p class="fs-20 fw-bold">@lang("entity.type.{$type}.index")</p>
		<table class="table table-sm table-bordered table-light table-props">
			<thead class="thead-dark">
				<tr>
					@if ($view->indexActions())
						<th style="width:1px;white-space:nowrap">@lang('entity.column.actions')</th>
					@endif
					@foreach ($view->indexColumns() as $colName => $colProperties)
						<th>@lang("entity.type.{$type}.column.{$colName}")</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach ($data as $entity)
					<tr>
						@if ($view->indexActions())
							<td style="width:1px;white-space:nowrap">
								{!!
								join(
									' | ',
									array_map(
										function ($action) use ($entity, $type) {
											return '<a href="'.route($action, ['id' => $entity->id(), 'type' => $type]).'">'.__("entity.action.{$action}").'</a>';
										},
										array_filter(
											$view->indexActions(),
											function ($action) {
												return $action !== 'create';
											}
										)
									)
								)
								!!}
							</td>
						@endif
						@foreach ($view->indexColumns() as $colName => $colProperties)
							<td>{{ $entity->{$colName} }}</td>
						@endforeach
					</tr>
				@endforeach
			</tbody>
		</table>
		@if (in_array('create', $view->indexActions()))
			<a href="{{ route('create', ['type' => $type]) }}" class="btn btn-primary btn-sm">@lang('entity.action.create')</a>
		@endif
	</section>
</div>
