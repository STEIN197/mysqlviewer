<aside class="nowrap">
	<ul class="list-unstyled">
		@foreach ($links as $link)
			@if ($link['visible'])
				<li class="{{ $link['active'] ? 'active' : '' }}">
					<a href="{{ $link['link'] }}" class="c-default fw-medium nolink">
						<i class="{{ $link['iconClass'] }}"></i>
						<span>{{ $link['name'] }}</span>
					</a>
				</li>
			@endif
		@endforeach
	</ul>
	<form action="">
		<x-form-field type="select" name="locale" :placeholder="__('messages.lang')" :items="App\Locale::getAll()" :activeItem="App::getLocale()"/>
	</form>
</aside>
