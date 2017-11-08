			<div class="form-group">
				<label class="required">Name</label>
				<input type="text" name="name" class="form-control" value="{{isset($user->name) ? $user->name : ''}}">
			</div>
			<div class="form-group">
				<label class="required">Email</label>
				<input type="email" name="email" class="form-control" value="{{isset($user->email) ? $user->email : ''}}">
			</div>
			<div class="form-group">
				<label{{ isset($user) ? '' : ' class=required'}}>Password</label>
				<input type="password" name="password" class="form-control">
				@if(isset($user))
				<div class="help-block">Leave if not change</div>
				@endif
			</div>
			<div class="form-group">
				<label>Picture</label>
				<input type="file" name="picture" class="form-control">
			</div>
			<div class="form-group">
				<label class="required">Roles</label>
				@foreach($roles as $role)
				<input type="checkbox" name="roles[]" value="{!! $role->id !!}" {{ isset($user) && in_array($role->id, $userRoles) ? 'checked' : '' }}> {{$role->display_name}}
				<div class="help-text">
				@isset($role->description)
					{!! $role->description !!}
				@endisset
				</div>
				@endforeach
			</div>
			<div class="form-group">
				@isset($user)
				<button class="btn btn-primary" type="submit">Update</button>
				@else
				<button class="btn btn-primary" type="submit">Create</button>
				@endisset
				<a href="{{ route('users.index') }}" class="btn btn-default">Back</a>
			</div>
