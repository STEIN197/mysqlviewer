@if (Auth::check())
	authenticated
@else
	not authenticated
@endif