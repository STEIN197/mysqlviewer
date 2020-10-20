
{{-- {{ var_dump(session()->get('user')) }} --}}
@if (auth()->check())
authenticated
@else
not authenticated
@endif
<section class="d-flex">
	<div class="container">
		<div class="row">
			<div class="col col-4 offset-4">
				<form action="" method="post" class="pd-20 border">
					@csrf
					@error('connection')
						<p class="alert alert-danger">@lang('auth.error')</p>
					@enderror
					<p class="text-center fw-bold fs-18">@lang('auth.auth')</p>
					<x-form-field type="text" name="host" :placeholder="__('auth.host')" default="localhost" required="true"/>
					<x-form-field type="text" name="username" :placeholder="__('auth.user')" required="true"/>
					<x-form-field type="password" name="password" :placeholder="__('auth.password')" required="true"/>
					<x-form-field type="text" name="database" :placeholder="__('auth.database')"/>
					<div class="row">
						<div class="col col-12 col-md-6">
							<x-form-field type="select" name="locale" :placeholder="__('messages.lang')" :items="App\Locale::getAll()" :activeItem="App::getLocale()"/>
						</div>
						{{-- <div class="col col-12 col-md-4">
							<a href="{{ route('logout', [], false) }}">@lang('auth.logout')</a>
						</div> --}}
						<div class="col col-12 col-md-6">
							<x-form-field type="button" name="login" :placeholder="__('auth.submit')" class="btn btn-primary btn-sm btn-block"/>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
