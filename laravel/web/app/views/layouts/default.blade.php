<!DOCTYPE HTML>
    <html>
    <head>
        <meta charset="utf-8">
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-2" style="float : left">
                    <ul class="list-group" style="padding-top:100px">
                        <li class="list-group-item">Admin</li>
                        <li class="list-group-item"></li>
                        <li class="list-group-item"><a href="/article">Articles</a></li>
                        <li class="list-group-item"><a href="/category">Categories</a></li>
                        <li class="list-group-item"><a href="/channel">Channels</a></li>
                        <li class="list-group-item"><a href="/event">Events</a></li>
                        <li class="list-group-item"><a href="/sponsor">Sponsors</a></li>
                        <li class="list-group-item"><a href="/venue">Venues</a></li>
                    </ul>

                    <ul class="list-group" style="padding-top:25px">
                        <li class="list-group-item">API</li>
                        <li class="list-group-item"></li>
                        <li class="list-group-item"><a href="/">/</a></li>
                        <li class="list-group-item"><a href="/register">Register</a></li>
                    </ul>
                </div>
                <div class="col-md-10" style="float : left">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>

    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script data-main="js/app" src="js/require.js"></script>
</html>
