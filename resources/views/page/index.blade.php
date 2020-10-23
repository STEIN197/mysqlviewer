<div class="container">
	<div class="row">
		<div class="col col-4 offset-4">
			<form action="{{ route('login') }}" method="post" class="pd-20 border">
				@csrf
				<p class="text-center fw-bold fs-18">@lang('auth.auth')</p>
				@if ($errors->any())
					@foreach ($errors->all() as $error)
						<p class="alert alert-danger pd-10">{{ $error }}</p>
					@endforeach
				@endif
				@error('connection')
					<p class="alert alert-danger pd-10">@lang('auth.error')</p>
				@enderror
				<x-form-field type="text" name="host" :placeholder="__('auth.host')" default="localhost" required="true"/>
				<x-form-field type="text" name="username" :placeholder="__('auth.user')" required="true"/>
				<x-form-field type="password" name="password" :placeholder="__('auth.password')"/>
				<x-form-field type="text" name="database" :placeholder="__('auth.database')"/>
				<div class="row">
					<div class="col col-12 col-md-6">
						<x-form-field type="select" name="locale" :placeholder="__('messages.lang')" :items="App\Locale::getAll()" :activeItem="App::getLocale()"/>
					</div>
					<div class="col col-12 col-md-6">
						<x-form-field type="button" name="login" :placeholder="__('auth.submit')" class="btn btn-primary btn-sm btn-block"/>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

