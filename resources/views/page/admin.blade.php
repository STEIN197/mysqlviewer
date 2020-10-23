<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<table class="table table-sm table-bordered table-light table-props">
			<tbody class="fs-20 fw-bold">
				<tr>
					<td colspan="2">@lang('admin.server.mysql.header')</td>
				</tr>
			</tbody>
			<tbody>
				<tr>
					<td>@lang('admin.server.mysql.version')</td>
					<td>{{ DB::select(DB::raw('SELECT VERSION() AS v'))[0]->v }}</td>
				</tr>
				<tr>
					<td>@lang('admin.server.mysql.user')</td>
					<td>{{ auth()->user()->getAuthIdentifier().'@'.auth()->user()->getHost() }}</td>
				</tr>
				<tr>
					<td>@lang('admin.server.mysql.charset')</td>
					<td>{{ config('database.connections.mysql.charset') }}</td>
				</tr>
				<tr>
					<td>@lang('admin.server.mysql.collation')</td>
					<td>{{ config('database.connections.mysql.collation') }}</td>
				</tr>
			</tbody>
			<tbody class="fs-20 fw-bold">
				<tr>
					<td colspan="2">@lang('admin.server.apache.header')</td>
				</tr>
			</tbody>
			<tbody>
				<tr>
					<td>@lang('admin.server.apache.version')</td>
					<td>{{ apache_get_version() }}</td>
				</tr>
				<tr>
					<td>@lang('admin.server.apache.modules')</td>
					<td>{{ join(', ',(apache_get_modules())) }}</td>
				</tr>
			</tbody>
			<tbody class="fs-20 fw-bold">
				<tr>
					<td colspan="2">@lang('admin.server.php.header')</td>
				</tr>
			</tbody>
			<tbody>
				<tr>
					<td>@lang('admin.server.php.version')</td>
					<td>{{ phpversion() }}</td>
				</tr>
				<tr>
					<td>@lang('admin.server.php.ext')</td>
					<td>{{ join(', ', get_loaded_extensions()) }}</td>
				</tr>
			</tbody>
		</table>
	</section>
</div>
