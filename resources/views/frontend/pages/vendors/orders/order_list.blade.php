@extends('frontend/master')
@section('headtitle', 'Daftar Transaksi')
@section('maincontent')
@include('frontend.includes.navbar-white')
<div class="uk-grid-small" uk-grid>
  <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-4@m uk-visible@s">
    @include('frontend.includes.vendors.navvendor')
  </div>
  <div class="uk-width-expand">
    @if( $myaccount->vendor_verified === 'N' )
    <div class="uk-margin-top uk-alert-warning" uk-alert>
      Akun Anda belum terverifikasi. Silahkan periksa kembali email inbox/spam Anda untuk verifikasi akun.
    </div>
    @endif
    @php
      $datavendor = [
        'vendor_logo' => $myaccount->vendor_logo,
        'vendor_name' => $myaccount->vendor_name,
        'vendor_id' => $myaccount->vendor_id
      ]
    @endphp
    <vendororderlist url="{{ url('/') }}" :vendors="{{ json_encode( $datavendor ) }}" />
  </div>
</div>
@endsection