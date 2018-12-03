@extends('frontend/master')
@section('headtitle', $portfolio->portfolio_name)
@section('maincontent')
@include('frontend.includes.navbar-white')
<div class="uk-grid-small" uk-grid>
  <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-4@m uk-visible@s">
    @include('frontend.includes.vendors.navvendor')
  </div>
  <div class="uk-width-expand">
    <div class="uk-container">
      @if( $myaccount->vendor_verified === 'N' )
      <div class="uk-margin-top uk-alert-warning" uk-alert>
        Akun Anda belum terverifikasi. Silahkan periksa kembali email inbox/spam Anda untuk verifikasi akun.
      </div>
      @endif
      <vendorportfolioimages url="{{ url('/') }}" :portfolio="{{ json_encode( $portfolio ) }}" />
    </div>
  </div>
</div>
@endsection
