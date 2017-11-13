@extends('layouts.app', ['title' => '[MODULE_DISPLAY_NAME_PLURAL]'])

@section('content')
@component('layouts.parts.header', ['title' => '[MODULE_DISPLAY_NAME_PLURAL]'])
<div class="pull-right">
    <a href="{{ route('[MODULE_NAME_PLURAL].form') }}" class="btn btn-primary btn-sm">Add New</a>
</div>
@endcomponent

@component('layouts.parts.alert')
@endcomponent

<div class="panel padding">
    <div class="panel-heading">
        <h4>[MODULE_DISPLAY_NAME_PLURAL]</h4>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <th width="10">No</th>
                    [FIELDS_COLUMN_HEADER]
                    <th width="200">Action</th>
                </tr>
                @if(count($[MODULE_NAME_PLURAL]))
                @foreach($[MODULE_NAME_PLURAL] as $[MODULE_NAME])
                <tr>
                    <td>{!! $no++ !!}</td>
                    [FIELDS_COLUMN_ROW]
                    <td>
                        {!! table_action([
                            'edit' => route('[MODULE_NAME_PLURAL].edit', $[MODULE_NAME]->id),
                            'delete' => route('[MODULE_NAME_PLURAL].delete', $[MODULE_NAME]->id)
                        ]) !!}
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="5" class="text-center">
                        <i>No [MODULE_DISPLAY_NAME_PLURAL], <a href="{{ route('[MODULE_NAME_PLURAL].form') }}">create one</a>.</i>
                    </td>
                </tr>
                @endif
            </table>
        </div>
        <div class="text-center">       
            {!! $[MODULE_NAME_PLURAL]->links() !!}
        </div>
    </div>
</div>
@stop