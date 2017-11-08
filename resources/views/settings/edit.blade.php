@extends('layouts.app', ['title' => 'Setting Group'])

@section('content')
@component('layouts.parts.header', ['title' => 'Edit Group Setting'])
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<form method="post" action="{{ route('settings.update', $setting->id) }}">
	{!! csrf_field() !!}
	{!! method_field('PUT') !!}
	<div class="panel padding">
		<div class="panel-heading">
			<h4>Edit Group</h4>
		</div>
		<div class="panel-body">
			@include('settings.fields')
		</div>
	</div>
</form>
@stop