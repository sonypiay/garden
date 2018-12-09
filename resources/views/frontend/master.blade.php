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
@if(
  $request->route()->getName() !== 'homepage' OR
  $request->route()->getName() !== 'loginpage_customer' OR
  $request->route()->getName() !== 'registerpage_customer' OR
  $request->route()->getName() !== 'registerpage_customer' OR
  $request->route()->getName() !== 'loginpage_vendor' OR
  $request->route()->getName() !== 'registerpage_vendor'
 )
<footer class="footer">
  <div class="uk-card uk-card-body uk-card-small uk-card-default">
    <div class="uk-container">
      <div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s">
          <div class="copyright">
            &copy; {{ date('Y') }}. Made with <span uk-icon="heart"></span> by Garden Buana
          </div>
        </div>
        <div class="uk-width-expand">
          <div class="uk-align-right footer_links">
            <a href="{{ route('aboutus') }}">Tentang Kami</a>
            <a href="#">Bergabung sebagai Vendor</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
@endif
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>
