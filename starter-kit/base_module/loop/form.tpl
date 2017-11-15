@extends('layouts.app', ['title' => 'Create [MODULE_DISPLAY_NAME]'])

@section('content')
@component('layouts.parts.header', ['title' => 'Create [MODULE_DISPLAY_NAME]'])
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<form method="post" action="{{ route('[MODULE_NAME_PLURAL].store') }}" enctype="multipart/form-data">
	{!! csrf_field() !!}
[MODULE_LAYOUT]
</form>
@stop