@extends('layouts.app', ['title' => 'Setting Items'])

@section('content')
@component('layouts.parts.header', ['title' => 'Setting Items'])
<div class="pull-right">
	<a href="{{ route('setting_items.create') }}" class="btn btn-primary btn-sm">Add New</a>
</div>
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<div class="panel padding">
	<div class="panel-heading">
		<h4>Setting Items</h4>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<tr>
					<th width="10">No</th>
					<th>Group</th>
					<th>Name</th>
					<th>Display Name</th>
					<th>Type</th>
					<th>Description</th>
					<th width="200">Action</th>
				</tr>
				@if(count($settings))
				@foreach($settings as $setting)
				<tr>
					<td>{!! $no++ !!}</td>
					<td>{!! optional($setting)->group->display_name !!}</td>
					<td>{!! $setting->name !!}</td>
					<td>{!! $setting->display_name !!}</td>
					<td>{!! Datatype::get($setting->type) !!}</td>
					<td>{!! if_null($setting->description, '<i>No Description</i>') !!}</td>
					<td>
						{!! table_action([
							'edit' => route('setting_items.edit', $setting->id),
							'delete' => route('setting_items.delete', $setting->id)
						]) !!}
					</td>
				</tr>
				@endforeach
				@else
				<tr>
					<td colspan="7" class="text-center">
						<i>No setting, <a href="{{ route('setting_items.create') }}">create one</a>.</i>
					</td>
				</tr>
				@endif
			</table>
		</div>
		<div class="text-center">		
			{!! $settings->links() !!}
		</div>
	</div>
</div>
@stop