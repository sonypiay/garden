@extends('frontend/master')
@section('headtitle', 'Garden Pages - Platform Pemesanan Jasa Tukang Kebun')
@section('maincontent')
<main>
  <div class="uk-cover-container uk-height-viewport cover-homepage">
    <img src="{{ asset('images/banner/bgcover.jpg') }}" alt="Photo by Markus Spiske on Unsplash" uk-cover>
    <div class="uk-overlay cover-overlay-homepage uk-position-cover">
      <div class="uk-container">
        <header class="header-hmpg">
          <div class="uk-navbar navbar-homepage" uk-navbar>
            <div class="uk-navbar-left">
              <ul class="uk-navbar-nav nav-hmpg">
                <li><a href="#aboutus">Tentang Kami</a></li>
                <li><a href="#">Cara Kerja</a></li>
              </ul>
            </div>
            <div class="uk-navbar-center">
              <a href="{{ url('/') }}" class="uk-navbar-item uk-logo logo-homepage-white">
                <img src="{{ asset('images/logobrand/gplogo-white.png') }}" alt="garden pages">
              </a>
            </div>
            <div class="uk-navbar-right">
              @include('frontend.includes.navbar-hmpg')
            </div>
          </div>
        </header>
        <div class="uk-width-1-2 findvendor-hmpg-content">
          <div class="uk-margin-bottom temukan-vendor-hmpg">Pesan <span class="tanamanhias">Jasa Tanaman Hias</span> Terbaik Anda</div>
          <div class="hmpg-findvendor-box">
            <div class="uk-grid-small" uk-grid>
              <div class="uk-width-1-1">
                <div class="uk-width-1-1 uk-inline">
                  <span class="uk-form-icon findvendor-formicon"><i class="fas fa-search"></i></span>
                  <input type="search" class="uk-width-1-1 uk-input uk-box-shadow-medium findvendor-form" placeholder="Aku ingin memesan...">
                </div>
              </div>
              <div class="uk-width-expand">
                <div class="uk-width-1-1 uk-inline">
                  <button class="uk-button uk-button-default findcity-hmpg">Pilih Kota <span class="fas fa-chevron-down"></span> </button>
                  <div class="dropdown-findcity" uk-dropdown="mode: click; pos: right-bottom;">
                    <ul class="uk-nav uk-dropdown-nav">
                      @foreach( $kabupaten as $kab )
                      <li><a href="#{{ $kab->kode_kab }}">{{ $kab->nama_kab }}</a></li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
