
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Payment Page</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body>
        <div class="container">
            <br />
            @if (\Session::has('sale_url'))
            <iframe src="{{ \Session::get('sale_url') }}" height="800" width="1000"></iframe>
            @endif

        </div>
    </body>
</html>