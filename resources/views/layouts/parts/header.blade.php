<div class="page-header">
	<h1>{!! $title !!}</h1>
	@isset($description)
	<p>{!! $description !!}</p>
	@endisset
	{!! $slot !!}
</div>