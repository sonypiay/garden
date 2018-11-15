<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
@include('administrator.includes.meta-header')
<title>@yield('headtitle')</title>
</head>
<body>
<header class="uk-navbar uk-box-shadow-medium header" uk-navbar>
  <div class="uk-navbar-left">
    <a class="uk-navbar-item uk-logo header-logo" href="{{ route('dashboard_admin') }}">
      <img class="uk-border-circle" src="{{ asset('images/logobrand/gplogo-white.png') }}" />
    </a>
  </div>
  <div class="uk-navbar-right">
    <ul class="uk-navbar-nav header-nav">
      <li><a href="#"><i class="material-icons">notifications_none</i></a></li>
      <li><a href="#">John Doe <span class="uk-margin-small-left"><i class="fas fa-chevron-down"></i></span></a>
        <div class="uk-navbar-dropdown uk-box-shadow-medium header-dropdown-container">
          <ul class="uk-nav uk-navbar-dropdown-nav header-dropdown-nav">
            <li><a href="#">Change Password</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="{{ route('logoutadminpage') }}">Logout</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</header>
<div class="uk-grid-collapse" uk-grid>
  <nav class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-4@m uk-visible@s">
    <div class="uk-card uk-card-body uk-card-small uk-card-secondary main-navbar-container" uk-height-viewport>
      @include('administrator.includes.navbar-left')
    </div>
  </nav>
  <div class="uk-width-expand">
    <div id="app">@yield('main_content')</div>
    <script src="{{ asset('js/app.admin.js') }}"></script>
  </div>
</div>
</body>
</html>
