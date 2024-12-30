<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/products.css') }}" rel="stylesheet">
    <link href="{{ asset('css/product_details.css') }}" rel="stylesheet">
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @yield('head') 
    <title>Application</title>
</head>
<body>
    <header class="header">
        <h1 style="color: #EECD46;">mogitate</h1>
    </header>
    @yield('content')
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
