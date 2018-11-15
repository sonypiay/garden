<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
@include('administrator.includes.meta-header')
<title>Garden Pages | Login</title>

</head>
<body>
<div id="app">
  <login-section url="{{ url('/') }}"></login-section>
</div>
<script src="{{ asset('js/app.admin.js') }}"></script>
</body>
</html>
