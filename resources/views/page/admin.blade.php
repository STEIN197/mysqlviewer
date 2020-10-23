<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<table class="table table-sm table-bordered table-light">
			<tbody>
				<tr>
					<td>@lang('admin.server.server')</td>
					<td>{{ auth()->user()->getHost() }}</td>
				</tr>
			</tbody>
		</table>
	</section>
</div>

