<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Segoe UI', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 36px;
                padding: 20px;
            }
            p {
                margin: 0;
                margin-bottom: 20px;
            }
            .buttons {
                display: inline-block;
                margin-top: 20px;
            }
            a.btn {
                background-color: #657DC4;
                border: 1px solid #657DC4;
                padding: 10px 15px;
                text-decoration: none;
                color: #fff;
                font-size: 14px;
            }
            a.btn:hover {
                background-color: transparent;
                color: #657DC4;
            }
            footer {
                position: absolute;
                bottom: 40px;
                font-weight: 400;
                width: 100%;
                text-align: center;
                font-size: 14px;
                color: #999;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title">
                    @yield('message')
                </div>
                <p>@yield('description')</p>
                <div class="buttons">
                    @auth
                    <a href="{{ route('dashboard') }}" class="btn">Back to Dashboard</a>
                    @else
                    <a href="javascript:window.history.back()" class="btn">Bring Me Back</a>
                    @endauth
                </div>
            </div>
        </div>
        <footer>
            Copyright &copy; {{config('app.name')}} {{date('Y')}}
        </footer>
    </body>
</html>
