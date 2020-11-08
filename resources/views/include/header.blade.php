<header class="d-flex align-items-center" style="height:40px;background-color:gray">
	<div class="container-fluid d-flex justify-content-between">
		<a href="/" class="nolink fw-bold fs-20" style="color:white">
			<i>mysqlviewer</i>
		</a>
		<p class="mb-0">
			<i class="fw-medium">{{ auth()->user()->getAuthIdentifier().'@'.auth()->user()->getHost() }}</i>
			<a href="{{ route('logout') }}" class="nolink c-white">
				<i class="fas fa-sign-out-alt fa-fw"></i>
				<span>@lang('route.logout')</span>
			</a>
		</p>
	</div>
</header>
