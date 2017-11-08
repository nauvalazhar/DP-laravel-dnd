@extends('layouts.app', ['title' => 'Setting Group'])

@section('content')
@component('layouts.parts.header', ['title' => 'Create Group Setting', 'description' => 'Create new group setting and you can use them by calling <code>settings(\'group_name\')</code>.'])
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<form method="post" action="{{ route('settings.store') }}">
	{!! csrf_field() !!}
	<div class="panel padding">
		<div class="panel-heading">
			<h4>Create Group</h4>
		</div>
		<div class="panel-body">
			@include('settings.fields')
		</div>
	</div>
</form>
@stop