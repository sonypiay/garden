@extends('frontend/master')
@section('headtitle', 'Garden Pages - Platform Pemesanan Jasa Tukang Kebun')
@section('maincontent')
<main>
  <div class="uk-cover-container uk-height-viewport cover-homepage">
    <img src="{{ asset('images/banner/Banner4.jpg') }}" alt="Photo by Markus Spiske on Unsplash" uk-cover>
    <div class="uk-overlay cover-overlay-homepage uk-position-cover">
      <header class="header-hmpg">
        <div class="uk-navbar navbar-homepage" uk-navbar>
          <!--<div class="uk-navbar-left">
            <ul class="uk-navbar-nav nav-hmpg">
              <li><a href="{{ route('aboutus') }}">Tentang Kami</a></li>
              <li><a href="{{ route('discoveryvendor_page') }}">Cari Vendor</a></li>
            </ul>
          </div>-->
          <div class="uk-navbar-left">
            <a href="{{ url('/') }}" class="uk-navbar-item uk-logo logo-homepage-white">
              <img class="uk-border-circle" src="{{ asset('images/logobrand/logobaru2.jpeg') }}" alt="garden pages">
            </a>
          </div>
          <div class="uk-navbar-right">
            @include('frontend.includes.navbar-hmpg')
          </div>
        </div>
      </header>
      <div class="uk-container">
        <div class="uk-width-1-2 uk-position-center-left findvendor-hmpg-content">
          <div class="temukan-vendor-hmpg">Pesan jasa taman hias yang terpercaya dan professional sesuai dengan kebutuhan Anda</div>
          <div class="hmpg-button">
            <div class="uk-grid-small" uk-grid>
              <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
                <a class="uk-display-block uk-button uk-button-default uk-button-large joinasvendor" href="{{ route('registerpage_vendor') }}">Bergabung Sebagai Vendor</a>
              </div>
              <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s">
                <a class="uk-display-block uk-button uk-button-default uk-button-large findvendor" href="{{ route('discoveryvendor_page') }}">Cari Vendor</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
