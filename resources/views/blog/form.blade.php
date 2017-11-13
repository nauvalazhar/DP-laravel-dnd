@extends('layouts.app', ['title' => 'Create Blog'])

@section('content')
@component('layouts.parts.header', ['title' => 'Create Blog'])
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<form method="post" action="{{ route('blogs.store') }}" enctype="multipart/form-data">
	{!! csrf_field() !!}
	<div class="row">
    <div class="col-lg-8">
        <div class="panel padding">
            <div class="panel-heading">
                <h4>Heading 4</h4>
            </div>
            <div class="panel-body">
                <div class="form-group"><label>Title</label><input type="text" name="title" class="form-control" />
                    <div class="help-text">Your description</div>
                </div>
                <div class="form-group"><label>Content</label><textarea name="content" class="form-control editor"></textarea></div>
                <div class="form-group"><label>Field Name</label><input type="file" name="field_name" class="form-control" /></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel padding">
            <div class="panel-heading">
                <h4>Publishment</h4>
            </div>
            <div class="panel-body">
                <div class="form-group"><label>Field Name</label><select name="field_name" class="form-control"><option value="draft">Draft</option><option value="publish">Publish</option></select></div><button class="btn btn-primary">Button</button></div>
        </div>
    </div>
</div>
</form>
@stop