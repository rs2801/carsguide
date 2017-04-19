<!DOCTYPE html>
<html lang="en">
    <head>

        <!-- Meta -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
        <link rel="apple-touch-icon-precomposed" href="/assets/images/icons/favicon-152.png" />
        <link rel="icon" sizes="32x32" href="/assets/images/icons/favicon-32.png" />

        <!-- Title -->
        <title>Cars Guide Technical Test</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700" rel="stylesheet">

        <!-- CSRF Token -->
        <script>
            window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!}
        </script>

    </head>
    <body>
        <div id="app">

            <div class="backgroundImage"></div>

            <nav class="navbar navbar-default" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <div class="navbar-brand">
                            <a href="/" title="Cars Guide">
                                <img src="/assets/images/logo.png" alt="Cars Guide" />
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

        	@yield('content')

        </div>

        <!-- Javascripts -->
        <script type="text/javascript" src="{{ mix('/assets/js/app.js') }}"></script>

        <!-- Styles -->
        <link href="{{ mix('/assets/css/app.css') }}" rel="stylesheet" type="text/css">

    </body>
</html>
