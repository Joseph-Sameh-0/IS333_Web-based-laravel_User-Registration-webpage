<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Default Title')</title>
    <link rel="stylesheet" href="{{ asset('css/Signing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @yield('head-extra')
</head>
<body>
@include('header')
<div style="height: 100px;"></div>

@yield('content')
@include('footer')

</body>
</html>
