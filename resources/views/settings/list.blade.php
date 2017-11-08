@extends('layouts.app', ['title' => 'Setting Group'])

@section('content')
@component('layouts.parts.header', ['title' => 'Setting Group'])
<div class="pull-right">
	<a href="{{ route('settings.create') }}" class="btn btn-primary btn-sm">Add New</a>
</div>
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<div class="panel padding">
	<div class="panel-heading">
		<h4>Setting Group</h4>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<tr>
					<th width="10">No</th>
					<th>Group Name</th>
					<th>Group Display Name</th>
					<th>Description</th>
					<th>Sort</th>
					<th width="200">Action</th>
				</tr>
				@if(count($settings))
				@foreach($settings as $group)
				<tr>
					<td>{!! $no++ !!}</td>
					<td>{!! $group->name !!}</td>
					<td>{!! $group->display_name !!}</td>
					<td>{!! if_null($group->description, '<i>No Description</i>') !!}</td>
					<td>{!! if_null($group->sort, '<i>No Sort</i>') !!}</td>
					<td>
						{!! table_action([
							'edit' => route('settings.edit', $group->id),
							'delete' => route('settings.delete', $group->id)
						]) !!}
					</td>
				</tr>
				@endforeach
				@else
				<tr>
					<td colspan="6" class="text-center">
						<i>No Group Setting, <a href="{{ route('settings.create') }}">create one</a>.</i>
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