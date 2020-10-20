@foreach (config('database.connections') as $conn)
	{{ $conn['database'] }}<br/>
@endforeach
