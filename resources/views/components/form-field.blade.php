<label class="form-group input-group-sm d-block{{ $required == 'true' ? ' required' : '' }}">
	<p class="placeholder mb-1">{!! $type === 'button' ? '&nbsp;' : $placeholder.($required ? '*' : '') !!}</p>
	@switch ($type)
		@case ('textarea')
			<textarea class="form-control" name="{{ $name }}"></textarea>
			@break
		@case ('select')
			<select class="form-control" name="{{ $name }}">
				@foreach ($items as $v)
				<option value="{{ $v }}" {{ $activeItem === $v ? 'selected' : '' }}>{{ $v }}</option>
				@endforeach
			</select>
			@break
		@case ('button')
			<button name="{{ $name }}" class="{{ $class }}">{{ $placeholder }}</button>
			@break
		@default
			<input class="form-control" type="{{ $type }}" name="{{ $name }}" value="{{ $default }}"/>
	@endswitch
</label>
