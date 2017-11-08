<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="required">Name</label>
			<input type="text" name="name" class="form-control" placeholder="e.g blog">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="required">Display Name</label>
			<input type="text" name="display_name" class="form-control" placeholder="e.g Blog">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label>Description</label>
			<input type="text" name="description" class="form-control">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="required">Type</label>
			<select class="form-control" name="type">
				@foreach(Datatype::module_type() as $k => $type)
				<option value="{!! $k !!}">{!! $type['display_name'] !!}</option>
				@endforeach
			</select>
			<div class="help-text">
				<a href="">Learn more about this</a>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 text-right">
		<div class="form-group">		
			<button class="btn btn-primary">Create &amp; Next</button>
			<div class="help-text">
				After creating this you will create a layout for this module
			</div>
		</div>
	</div>
</div>
