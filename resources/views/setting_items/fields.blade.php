			<div class="form-group">
				<label class="required">Setting Group</label>
				<select class="form-control setting-group" name="settings_id">
					@foreach(Settings::getGroup() as $group)
					<option data-sort="{{isset($sort[$group->id]) ? $sort[$group->id] : 1}}" value="{!! $group->id !!}"{{isset($setting) ? ($group->id == $setting->setting_id ? 'selected' : '') : ''}}>{!! $group->display_name !!}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label class="required">Name</label>
				<input type="text" name="name" class="form-control" value="{{isset($setting->name) ? $setting->name : ''}}">
				<div class="help-text">
					Use _ instead of space.
				</div>
			</div>
			<div class="form-group">
				<label class="required">Display Name</label>
				<input type="text" name="display_name" class="form-control" value="{{isset($setting->display_name) ? $setting->display_name : ''}}">
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label class="required">Type</label>
						<select class="form-control" name="type">
							@foreach(Datatype::list() as $k => $type)
							<option value="{!! $k !!}"{{isset($setting) ? ($k == Datatype::get($setting->type) ? 'selected' : '') : ''}}>{!! $type['display_name'] !!}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-md-7">
					<div class="form-group">
						<label>Options (This field is used for <code>checkbox</code> type, <code>radio</code> and <code>select</code>)</label>
						<input type="text" class="form-control" name="attrs[options]" placeholder="E.g: Apple, Orange, etc" value="{{isset($setting->type) ? Datatype::getOptions($setting->type) : ''}}">
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label>Required?</label>
						<select class="form-control" name="attrs[required]">
							<option value="1" {{isset($setting) && Settings::isRequired($setting->name) ? 'selected' : ''}}>Yes</option>
							<option value="0" {{isset($setting) && !Settings::isRequired($setting->name) ? 'selected' : ''}}>No</option>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Description</label>
				<textarea name="description" class="form-control">{{isset($setting->description) ? $setting->description : ''}}</textarea>
			</div>
			<div class="form-group">
				<label>Sort</label>
				<input type="number" name="sort" class="form-control" value="{{isset($setting->sort) ? $setting->sort : ''}}">
			</div>
			<div class="form-group">
				@isset($setting)
				<button class="btn btn-primary" type="submit">Update</button>
				@else
				<button class="btn btn-primary" type="submit">Create</button>
				@endisset
				<a href="{{ route('setting_items.list') }}" class="btn btn-default">Back</a>
			</div>

@section('foot')
<script>
	let setting_group = $(".setting-group");
	$("[name=sort]").val(setting_group.find(":selected").attr('data-sort'));
	setting_group.change(function() {
		$("[name=sort]").val(setting_group.find(":selected").attr('data-sort'));
	});
</script>
@stop