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
			<div class="form-group">
				<label>Description</label>
				<textarea name="description" class="form-control">{{isset($setting->description) ? $setting->description : ''}}</textarea>
			</div>
			<div class="form-group">
				<label>Sort</label>
				<input type="number" name="sort" class="form-control" value="{{isset($setting->sort) ? $setting->sort : $sort}}">
			</div>
			<div class="form-group">
				@isset($setting)
				<button class="btn btn-primary" type="submit">Update</button>
				@else
				<button class="btn btn-primary" type="submit">Create</button>
				@endisset
				<a href="{{ route('settings.list') }}" class="btn btn-default">Back</a>
			</div>
