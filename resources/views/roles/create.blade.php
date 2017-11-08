@extends('layouts.app', ['title' => 'Create Role'])

@section('content')
@component('layouts.parts.header', ['title' => 'Create Role'])
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<form method="post" action="{{ route('roles.store') }}">
	{!! csrf_field() !!}
	<div class="panel padding">
		<div class="panel-heading">
			<h4>Create Role</h4>
		</div>
		<div class="panel-body">
			@include('roles.fields')
		</div>
	</div>
</form>
@stop