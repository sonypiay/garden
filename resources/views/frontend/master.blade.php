<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
@include('frontend.includes.meta-header')
<title>@yield('headtitle')</title>
</head>
<body>
<div id="app">
@yield('maincontent')
</div>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>
