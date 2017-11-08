@extends('layouts.app', ['title' => 'Settings'])

@section('content')
@component('layouts.parts.header', ['title' => 'Settings'])
@endcomponent


@component('layouts.parts.alert')
@endcomponent

<div class="row">
	<div class="col-md-3">
		<div class="panel">
			<div class="panel-body">		
				<ul class="nav nav-pills nav-stacked">
					@foreach(Settings::getGroup() as $group)
					<li{{($setting->name == $group->name ? ' class=active' : '')}}><a href="{{ route('settings', $group->name) }}">{!! $group->display_name !!}</a></li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<form action="{!! route('settings.save', $setting->name) !!}" method="post" enctype="multipart/form-data">
			{!! csrf_field() !!}
			{!! method_field('PUT') !!}
			<div class="panel padding">
				<div class="panel-heading">
					<h4>{!! $setting->display_name !!}</h4>
				</div>
				<div class="panel-body">
					@isset($setting->description)
					<p>{!! $setting->description !!}</p>
					@endisset

					@if(count($setting->items))
					@foreach($setting->items as $item)
						{!! Datatype::render($item, setting($item->name)) !!}
					@endforeach
					@else
					<div class="text-center">
						<i>No Setting</i>
					</div>
					@endif
				</div>
				@if(count($setting->items))
				<div class="panel-footer">
					<button class="btn btn-primary">Save Changes</button>
				</div>
				@endif
			</div>
		</form>
	</div>
</div>
@stop