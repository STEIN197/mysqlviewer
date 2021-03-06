<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<p class="fs-20 fw-bold">@lang('admin.users.header')</p>
		<table class="table table-sm table-bordered table-light table-props">
			<thead class="thead-dark">
				<tr>
					<th>@lang('admin.users.name')</th>
					<th>@lang('admin.users.host')</th>
					<th>@lang('admin.users.edit')</th>
					<th>@lang('admin.users.delete')</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($variables as $row)
					<tr>
						<td>{{ $row->User }}</td>
						<td>{{ $row->Host }}</td>
						<td>
							<a href={{ route('admin.user', ['name' => "{$row->User}@{$row->Host}"]) }}>@lang('admin.users.edit')</a>
						</td>
						<td>
							<a href="{{ route('admin.deleteEntity', ['type' => 'user', 'id' => "{$row->User}@{$row->Host}"]) }}">@lang('admin.users.delete')</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<a href="{{ route('admin.newEntity', ['type' => 'user']) }}" class="btn btn-primary btn-sm">@lang('admin.add')</a>
	</section>
</div>
