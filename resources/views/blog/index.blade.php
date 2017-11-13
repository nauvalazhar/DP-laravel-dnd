@extends('layouts.app', ['title' => 'Blogs'])

@section('content')
@component('layouts.parts.header', ['title' => 'Blogs'])
<div class="pull-right">
    <a href="{{ route('blogs.form') }}" class="btn btn-primary btn-sm">Add New</a>
</div>
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<div class="panel padding">
    <div class="panel-heading">
        <h4>Blogs</h4>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <th width="10">No</th>
                    
                    <th width="200">Action</th>
                </tr>
                @if(count($blogs))
                @foreach($blogs as $blog)
                <tr>
                    <td>{!! $no++ !!}</td>
                    
                    <td>
                        {!! table_action([
                            'edit' => route('blogs.edit', $blog->id),
                            'delete' => route('blogs.delete', $blog->id)
                        ]) !!}
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="5" class="text-center">
                        <i>No Blogs, <a href="{{ route('blogs.form') }}">create one</a>.</i>
                    </td>
                </tr>
                @endif
            </table>
        </div>
        <div class="text-center">       
            {!! $blogs->links() !!}
        </div>
    </div>
</div>
@stop