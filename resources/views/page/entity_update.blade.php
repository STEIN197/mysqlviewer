<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<form action="" method="post">
			@csrf
			<p class="fs-20 fw-bold">{{ $entity->id() }}</p>
			<table class="table table-sm table-bordered table-light table-props">
				<tbody>
					@foreach ($view->editableProperties() as $colName => $colProperties)
						@php
						$inputAttributes = [
							'type' => @$colProperties['type'] ?? 'text',
							'name' => $colName,
							'value' => @$colProperties['reset'] ? '' : $entity->{$colName}
						];
						if (@$colProperties['type'] === 'checkbox' && \App\Util::toBool($entity->{$colName}))
							$inputAttributes['checked'] = '';
						if (@$colProperties['readonly']) {
							$inputAttributes['readonly'] = '';
							$inputAttributes['disabled'] = '';
						}
						array_walk($inputAttributes, function (&$value, $key) {
							$value = "{$key}=\"".htmlentities($value).'"';
						});
						$input = '<input '.join(' ', $inputAttributes).'/>';
						if (@$colProperties['type'] === 'select') {
							$input = "<select name=\"{$colName}\" value=\"".htmlentities($entity->{$colName})."\">";
							ob_start();
							@endphp
								@foreach (@$colProperties['options'] as $option)
									<option value="{{ $option }}" @if ($option === $entity->{$colName}) selected="" @endif>{{ $option }}</option>
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
			<button class="btn btn-primary btn-sm">@lang('entity.action.submit')</button>
		</form>
		<br/>
	</section>
</div>
