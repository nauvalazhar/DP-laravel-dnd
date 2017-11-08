<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ (isset($title) ? $title : 'Untitled Document') . ' &mdash; ' . config('app.name') }}</title>

    <link rel="stylesheet" href="{{ url('scripts/ionicons/css/ionicons.min.css') }}">
    <link href="{{ url('scripts/datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ url('scripts/icheck/skins/all.css') }}" rel="stylesheet">
    <link href="{{ url('scripts/timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet">
    <link href="{{ url('scripts/codemirror/lib/codemirror.css') }}" rel="stylesheet">
    <link href="{{ url('scripts/codemirror/theme/neo.css') }}" rel="stylesheet">
    <link href="{{ url('scripts/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    @yield('head')
</head>
<body>
    <div id="app">
        @if(Auth::check())
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Starter Kit') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li class="dropdown"><a role="button" class="has-icon dropdown-toggle notif-toggle" data-toggle="dropdown"><i class="ion ion-ios-bell-outline"></i><div class="badge notif-count">{!! Notifications::count() !!}</div></a>
                        <div class="dropdown-menu notification">
                            <h4>Notifications</h4>
                            <ul>
                                @foreach(Notifications::all() as $notification)
                                <li><a {{isset($notification->link) ? 'href=' . $notification->link : ''}}>
                                    <div class="icon{{isset($notification->class) ? ' ' . $notification->class : ''}}">
                                        <i class="ion {{!isset($notification->icon) ? 'ion-ios-bell-outline' : $notification->icon}}"></i>
                                    </div>
                                    <div class="desc">
                                        <b>{!! $notification->title !!}</b>
                                        <p>{!! $notification->content !!}</p>
                                    </div>
                                    <div class="time">
                                        {!! $notification->created_at->diffForHumans() !!}
                                    </div>
                                </a></li>
                                @endforeach
                            </ul>
                            <a href="{{ route('users.notifications', Auth::user()->id) }}" class="foot">See All Notifications</a>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{!! route('frontend') !!}">View Site</a></li>
                            <li><a href="{!! route('users.edit', Auth::user()->id) !!}">Profile</a></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="sidemenu">
            <div class="sidemenu-inner">            
                @if(@$menu !== false)
                @include('layouts.menus')
                @endif
                @yield('sidemenu')
            </div>
        </div>

        <div class="main">        
            <div class="inner-main">
        @endif
            @yield('content')

        @if(Auth::check())
        </div>
            <div class="footer">
                Copyright &copy; {{config('app.name')}} {{date('Y')}}
                <div class="pull-right">
                    Version {!! Starter::version() !!}
                </div>
            </div>
        </div>
        @endif

        @if(!Auth::check())
        <div class="footer">
            Copyright &copy; {{config('app.name')}} {{date('Y')}}
        </div>
        @endif
    </div>

    <!-- Scripts -->
    <script src="{{ url('js/app.js') }}"></script>
    <script src="{{ url('scripts/sweetalert/sweetalert.js') }}"></script>
    <script src="{{ url('scripts/cleave/dist/cleave.min.js') }}"></script>
    <script src="{{ url('scripts/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ url('scripts/icheck/icheck.min.js') }}"></script>
    <script src="{{ url('scripts/timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ url('scripts/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ url('scripts/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ url('scripts/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ url('scripts/html2json/lib/Pure-JavaScript-HTML5-Parser/htmlparser.js') }}"></script>
    <script src="{{ url('scripts/html2json/src/html2json.js') }}"></script>
    <script src="{{ url('scripts/filesaver/FileSaver.min.js') }}"></script>
    <script src="{{ url('scripts/stuk-jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ url('scripts/underscore/underscore.js') }}"></script>
    <script src="{{ url('scripts/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ url('scripts/showdown/dist/showdown.min.js') }}"></script>
    <script>let base_url = '{{url('')}}';</script>
    <script src="{{ url('js/custom.js') }}"></script>
    @yield('foot')
</body>
</html>
