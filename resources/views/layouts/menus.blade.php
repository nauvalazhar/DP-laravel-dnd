            <ul>
                <li class="{!! is_page('dashboard') ? 'active' : '' !!}"><a href="{{ route('dashboard') }}"><i class="ion ion-speedometer"></i> Dashboard</a></li>
                <li class="{!! is_page('users') ? 'active' : '' !!}"><a href="{{ route('users.index') }}"><i class="ion ion-ios-person"></i> Users</a></li>
                <li class="{!! is_page('roles') ? 'active' : '' !!}"><a href="{{ route('roles.index') }}"><i class="ion ion-lock-combination"></i> Roles</a></li>
                <li class="{!! is_page('settings') ? 'active' : '' !!}"><a href="{{ route('settings') }}"><i class="ion ion-gear-a"></i> Settings</a></li>
                @role('developer')
                <li class="has-tree{!! is_page('dev') ? ' active' : '' !!}">
                	<a role="button"><i class="ion ion-code"></i> Developers</a>
                	<ul>
                		<li class="{!! is_page('dev/modules') ? 'active' : '' !!}"><a href="{!! route('modules.layout') !!}"><i class="ion ion-ios-circle-outline"></i> Modules</a></li>
                        <li class="{!! is_page('dev/settings') ? 'active' : '' !!}"><a href="{!! route('settings.list') !!}"><i class="ion ion-ios-circle-outline"></i> Setting Group</a></li>
                        <li class="{!! is_page('dev/setting_items') ? 'active' : '' !!}"><a href="{!! route('setting_items.list') !!}"><i class="ion ion-ios-circle-outline"></i> Setting Item</a></li>
                	</ul>
                </li>
                @endrole
            </ul>
            <div class="under-nav">            
                <a href="{{ route('modules.layout') }}" class="btn btn-primary btn-block"><i class="ion ion-plus"></i> Create New Module</a>
            </div>
