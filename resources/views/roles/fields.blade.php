			<div class="form-group">
				<label class="required">Name</label>
				<input type="text" name="name" class="form-control" value="{{isset($roles->name) ? $roles->name : ''}}">
				<div class="help-text">
					Use _ instead of space.
				</div>
			</div>
			<div class="form-group">
				<label class="required">Display Name</label>
				<input type="text" name="display_name" class="form-control" value="{{isset($roles->display_name) ? $roles->display_name : ''}}">
			</div>
			<div class="form-group">
				<label>Description</label>
				<textarea name="description" class="form-control">{{isset($roles->description) ? $roles->description : ''}}</textarea>
			</div>
			<div class="form-group">
				<label class="required">Permissions</label>
				<br>

				@foreach($permission as $k => $perms)
					<h4><input type="checkbox" class="checkall" data-target="{{$k}}"> {{ucwords(human_string($k))}}</h4>
					@foreach($perms as $value)
						<input type="checkbox" name="permission[]" data-group="{{$k}}" value="{{$value->id}}" {{(isset($rolePermission) && in_array($value->id, $rolePermission) ? 'checked' : '')}}>
							{{ $value->display_name }} 
						@isset($value->description)
						&mdash; 
						<div class="help-text inline">
							{!! $value->description !!}
						</div>
						@endisset
					<br>
					@endforeach
					<br>
				@endforeach
			</div>
			<div class="form-group">
				@isset($roles)
				<button class="btn btn-primary" type="submit">Update</button>
				@else
				<button class="btn btn-primary" type="submit">Create</button>
				@endisset
				<a href="{{ route('roles.index') }}" class="btn btn-default">Back</a>
			</div>

@section('foot')
<script>
	$("input").iCheck('destroy');
	$(document).on("click", ".checkall", function() {
		let $this = $(this),
				target = $("[data-group='" + $this.attr('data-target') + "']");

		if($this.is(':checked')) {
			target.prop('checked', true);
		}else{
			target.prop('checked', false);
		}
	});
</script>
@stop