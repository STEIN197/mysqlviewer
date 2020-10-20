<header>
	<div class="container">
		<ul class="nav nav-pills d-flex justify-content-start">
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('admin') }}" aria-selected="true">@lang('route.admin')</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('admin.tables') }}" aria-selected="false">@lang('route.tables')</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('admin.sql') }}" aria-controls="pills-contact" aria-selected="false">@lang('route.sql')</a>
			</li>
			<li class="dropdown ml-auto">
				<button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('route.profile')</button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="{{ route('logout') }}">@lang('route.logout')</a>
				</div>
			  </li>
		</ul>
	</div>
</header>
