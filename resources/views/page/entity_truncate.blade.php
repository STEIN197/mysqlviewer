<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<p class="fs-20 fw-bold">@lang('entity.action.truncate') {{ $entity->id() }}?</p>
		<form action="" method="post">
			@csrf
			<button class="btn btn-primary btn-sm">@lang('entity.action.truncate')</button>
		</form>
	</section>
</div>
