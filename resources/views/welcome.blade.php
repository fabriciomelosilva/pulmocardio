<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Pulmão Ativo') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">

        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('image/favicon.ico') }}">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Comfortaa', cursive;
                font-weight: 200;
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

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
                color: #12AADA;
                font-weight: bold;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">{{ __('messages.home') }}</a>
                    @else
                        <a href="{{ route('login') }}">{{ __('messages.login') }}</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">{{ __('messages.register') }}</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Pulmão Ativo
                </div>

                <div class="links">
                    Pulmão Ativo
                </div>
            </div>
        </div>
    </body>
</html>
