<aside class="nowrap">
	<ul class="list-unstyled">
		@foreach ($links as $link)
			<li class="{{ $link['active'] ? 'active' : '' }}">
				<a href="{{ $link['link'] }}" class="c-default fw-medium nolink">
					<i class="{{ $link['iconClass'] }}"></i>
					<span>{{ $link['name'] }}</span>
				</a>
				@if (@$link['items'])
					<ul class="list-unstyled{{ @$link['expands'] ? ' js-accordion' : '' }}">
						@foreach ($link['items'] as $child)
							<li class="{{ @$link['expands'] ? 'js-accordion-item collapsed' : '' }} {{ $child['active'] ? 'active' : '' }}">
								@if (@$link['expands'])
									<a href="javascript:void(0)" class="fas fa-fw fa-plus-square cp c-default js-accordion-button"></a>
									<a href="javascript:void(0)" class="fas fa-fw fa-minus-square cp c-default js-accordion-button"></a>
								@endif
								<a href="{{ $child['link'] }}" class="c-default fw-medium nolink">
									<i class="{{ @$child['iconClass'] }}"></i>
									<span>{{ $child['name'] }}</span>
								</a>
							</li>
						@endforeach
					</ul>
				@endif
			</li>
		@endforeach
	</ul>
	<form action="">
		<x-form-field type="select" name="locale" :placeholder="__('messages.lang')" :items="App\Locale::getAll()" :activeItem="App::getLocale()"/>
	</form>
</aside>
