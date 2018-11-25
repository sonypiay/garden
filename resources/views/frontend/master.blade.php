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
@if( $request->route()->getName() !== 'homepage' )
<footer class="footer">
  <div class="uk-card uk-card-body uk-card-small uk-card-default">
    <div class="uk-container">
      <div class="footer_links">
        <a href="#">Tentang Kami</a>
        <a href="#">Kontak</a>
        <a href="#">Bergabung sebagai Vendor</a>
      </div>
    </div>
  </div>
</footer>
@endif
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>
