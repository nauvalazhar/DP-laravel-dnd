@extends('layouts.app', ['title' => 'Create User'])

@section('content')
@component('layouts.parts.header', ['title' => 'Create User'])
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<form method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
	{!! csrf_field() !!}
	<div class="panel padding">
		<div class="panel-heading">
			<h4>Create User</h4>
		</div>
		<div class="panel-body">
			@include('users.fields')
		</div>
	</div>
</form>
@stop