@extends('layouts.app', ['title' => 'Users'])

@section('content')
@component('layouts.parts.header', ['title' => 'Users'])
<div class="pull-right">
	<a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">Add New</a>
</div>
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<div class="panel padding">
	<div class="panel-heading">
		<h4>Users</h4>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<tr>
					<th width="10">No</th>
					<th>Name</th>
					<th>Email</th>
					<th>Role</th>
					<th>Picture</th>
					<th width="200">Action</th>
				</tr>
				@if(count($users))
				@foreach($users as $user)
				<tr>
					<td>{!! $no++ !!}</td>
					<td>{!! $user->name !!}</td>
					<td>{!! $user->email !!}</td>
					<td>
            @foreach($user->roles as $role)
            <div class="badge">{{$role->display_name}}</div>
            @endforeach
					</td>
					<td><img src="{!! images($user->picture) !!}" alt="{{$user->name}}'s photo" width="50"></td>
					<td>
						{!! table_action([
							'edit' => route('users.edit', $user->id),
							'delete' => route('users.delete', $user->id)
						]) !!}
					</td>
				</tr>
				@endforeach
				@else
				<tr>
					<td colspan="5" class="text-center">
						<i>No user, <a href="{{ route('users.create') }}">create one</a>.</i>
					</td>
				</tr>
				@endif
			</table>
		</div>
		<div class="text-center">		
			{!! $users->links() !!}
		</div>
	</div>
</div>
@stop