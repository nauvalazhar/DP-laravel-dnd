@extends('layouts.app', ['title' => 'Create Module'])

@section('content')
@component('layouts.parts.header', ['title' => 'Create Module', 'description' => 'Create new module for each sections in your HTML template.'])
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<form method="post" action="{{ route('modules.store') }}">
	{!! csrf_field() !!}
	<div class="panel padding">
		<div class="panel-heading">
			<h4>Create Module</h4>
		</div>
		<div class="panel-body">
			@include('modules.fields')
		</div>
	</div>
</form>
@stop