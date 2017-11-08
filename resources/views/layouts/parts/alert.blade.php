@if(session('error') || count($errors))
<div class="alert alert-danger">
	@if(count($errors))
		<p>Whoops, something went wrong:</p>
		<ul>
		@foreach($errors->all() as $error)
			<li>{!! $error !!}</li>
		@endforeach
		</ul>
	@else
		@if(is_array(session('error')))
		<p>Whoops, something went wrong:</p>
		<ul>
			@foreach(session('error') as $error)
			<li>{!! $error !!}</li>
			@endforeach
		</ul>
		@else
		{!! session('error') !!}
		@endif
	@endif
</div>
@endif

@if(session('success'))
<div class="alert alert-success">
	{!! session('success') !!}
</div>
@endif