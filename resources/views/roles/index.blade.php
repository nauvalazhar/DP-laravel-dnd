@extends('layouts.app', ['title' => 'Roles'])

@section('content')
@component('layouts.parts.header', ['title' => 'Roles'])
<div class="pull-right">
	<a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">Add New</a>
</div>
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<div class="panel padding">
	<div class="panel-heading">
		<h4>Roles</h4>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<tr>
					<th width="10">No</th>
					<th>Name</th>
					<th>Display Name</th>
					<th>Description</th>
					<th width="200">Action</th>
				</tr>
				@if(count($roles))
				@foreach($roles as $role)
				<tr>
					<td>{!! $no++ !!}</td>
					<td>{!! $role->name !!}</td>
					<td>{!! $role->display_name !!}</td>
					<td>{!! if_null($role->description, '<i>No Description</i>') !!}</td>
					<td>
						{!! table_action([
							'edit' => route('roles.edit', $role->id),
							'delete' => route('roles.delete', $role->id)
						]) !!}
					</td>
				</tr>
				@endforeach
				@else
				<tr>
					<td colspan="5" class="text-center">
						<i>No role, <a href="{{ route('roles.create') }}">create one</a>.</i>
					</td>
				</tr>
				@endif
			</table>
		</div>
		<div class="text-center">		
			{!! $roles->links() !!}
		</div>
	</div>
</div>
@stop