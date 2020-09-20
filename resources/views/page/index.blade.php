
@if (Auth::check())
authenticated
@else
not authenticated
@endif
<section>
	<div class="container">
		<div class="row">
			<div class="col col-6 offset-3">
				<form action="" method="post">
					@csrf
					@error('connection')
						<p class="alert alert-danger">@lang('auth.error')</p>
					@enderror
					<p>@lang('auth.auth')</p>
					<x-form-field type="select" name="locale" :placeholder="__('messages.lang')" :items="App\Locale::getAll()" :activeItem="App::getLocale()"/>
					<x-form-field type="text" name="username" :placeholder="__('auth.user')"/>
					<x-form-field type="password" name="password" :placeholder="__('auth.password')"/>
					<button class="btn btn-primary">@lang('auth.submit')</button>
				</form>
			</div>
		</div>
	</div>
</section>
