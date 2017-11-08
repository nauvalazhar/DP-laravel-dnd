@extends('layouts.app', ['title' => 'Setting Items'])

@section('content')
@component('layouts.parts.header', ['title' => 'Edit Item Setting'])
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<form method="post" action="{{ route('setting_items.update', $setting->id) }}">
	{!! csrf_field() !!}
	{!! method_field('PUT') !!}
	<div class="panel padding">
		<div class="panel-heading">
			<h4>Edit Setting</h4>
		</div>
		<div class="panel-body">
			@include('setting_items.fields')
		</div>
	</div>
</form>
@stop