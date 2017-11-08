@extends('layouts.app', ['title' => 'Edit User'])

@section('content')
@component('layouts.parts.header', ['title' => 'Edit User'])
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<form method="post" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
	{!! csrf_field() !!}
	{!! method_field('PUT') !!}
	<div class="panel padding">
		<div class="panel-heading">
			<h4>Edit User</h4>
		</div>
		<div class="panel-body">
			@include('users.fields')
		</div>
	</div>
</form>
@stop