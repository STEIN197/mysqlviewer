<aside>
	<ul class="list-unstyled">
		@foreach ($links as $link)
			<li class="{{ $link['active'] ? 'active' : '' }}">
				<a href="{{ $link['link'] }}" class="c-default fw-medium nolink">{{ $link['name'] }}</a>
				@if (@$link['items'])
					<ul class="list-unstyled">
						@foreach ($link['items'] as $child)
							<li class="{{ $child['active'] ? 'active' : '' }}">
								<a href="{{ $child['link'] }}" class="c-default fw-medium nolink">{{ $child['name'] }}</a>
							</li>
						@endforeach
					</ul>
				@endif
			</li>
		@endforeach
	</ul>
</aside>
