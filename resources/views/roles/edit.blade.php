@extends('layouts.app', ['title' => 'Edit Role'])

@section('content')
@component('layouts.parts.header', ['title' => 'Edit Role'])
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<form method="post" action="{{ route('roles.update', $roles->id) }}">
	{!! csrf_field() !!}
	{!! method_field('PUT') !!}
	<div class="panel padding">
		<div class="panel-heading">
			<h4>Edit Role</h4>
		</div>
		<div class="panel-body">
			@include('roles.fields')
		</div>
	</div>
</form>
@stop