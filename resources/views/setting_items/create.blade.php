@extends('layouts.app', ['title' => 'Setting Items'])

@section('content')
@component('layouts.parts.header', ['title' => 'Create Item Setting', 'description' => 'Create new item setting and you can use them by calling <code>settings(\'name\')</code>.'])
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<form method="post" action="{{ route('setting_items.store') }}">
	{!! csrf_field() !!}
	<div class="panel padding">
		<div class="panel-heading">
			<h4>Create Setting</h4>
		</div>
		<div class="panel-body">
			@include('setting_items.fields')
		</div>
	</div>
</form>
@stop