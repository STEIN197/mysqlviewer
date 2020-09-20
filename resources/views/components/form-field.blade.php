<label class="field {{ $type }}">
	<p class="placeholder">{{ $placeholder }}</p>
	@if ($type === 'textarea')
		<textarea name="{{ $name }}"></textarea>
	@elseif ($type === 'select')
		<select name="{{ $name }}">
			@foreach ($items as $v)
				<option value="{{ $v }}" {{ $activeItem === $v ? 'selected' : '' }}>{{ $v }}</option>
			@endforeach
		</select>
	@else
		<input type="text" name="{{ $name }}"/>
	@endif
</label>
