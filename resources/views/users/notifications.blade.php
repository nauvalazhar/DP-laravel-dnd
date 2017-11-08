@extends('layouts.app', ['title' => 'Notifications'])

@section('content')
@component('layouts.parts.header', ['title' => 'Notifications'])
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<div class="panel padding">
	<div class="panel-heading">
		<h4>Notifications</h4>
	</div>
	<div class="panel-body">
		<div class="notification">		
			<ul>			
		    @foreach(Notifications::me() as $notification)
		    <li><a {{isset($notification->link) ? 'href=' . $notification->link : ''}}>
		        <div class="icon{{isset($notification->class) ? ' ' . $notification->class : ''}}">
		            <i class="ion {{!isset($notification->icon) ? 'ion-ios-bell-outline' : $notification->icon}}"></i>
		        </div>
		        <div class="desc">
		            <b>{!! $notification->title !!}</b>
		            <p>{!! $notification->content !!}</p>
		        </div>
		    </a></li>
		    @endforeach
			</ul>
		</div>
		<div class="text-center">
			{!! Notifications::me()->links() !!}
		</div>
	</div>
</div>
@stop