<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<form action="" method="post">
			@csrf
			<p class="fs-20 fw-bold">@lang("entity.type.{$type}.action.create")</p>
			<table class="table table-sm table-bordered table-light table-props">
				<tbody>
					@foreach ($view->editableProperties() as $colName => $colProperties)
						@php
						$inputAttributes = [
							'type' => @$colProperties['type'] ?? 'text',
							'name' => $colName,
						];
						if (@$colProperties['required'])
							$inputAttributes['required'] = '';
						if (isset($colProperties['default']))
							$inputAttributes['value'] = $colProperties['default'];
						array_walk($inputAttributes, function (&$value, $key) {
							$value = "{$key}=\"".htmlentities($value).'"';
						});
						$input = '<input '.join(' ', $inputAttributes).'/>';
						if (@$colProperties['type'] === 'select') {
							$input = "<select name=\"{$colName}\">";
							ob_start();
							@endphp
								@foreach (@$colProperties['options'] as $option)
									<option value="{{ $option }}">{{ $option }}</option>
								@endforeach
							@php
							$input .= ob_get_clean();
							$input .= '</select>';
						}
						@endphp
						<tr>
							<td>@lang("entity.type.{$type}.column.{$colName}")</td>
							<td>{!! $input !!}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<button class="btn btn-primary btn-sm">@lang('entity.action.create')</button>
		</form>
		<br/>
	</section>
</div>
