@extends('frontend/master')
@section('headtitle', 'Daftar Transaksi')
@section('maincontent')
@include('frontend.includes.navbar-white')
<div class="uk-grid-small" uk-grid>
  <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-4@m uk-visible@s">
    @include('frontend.includes.vendors.navvendor')
  </div>
  <div class="uk-width-expand">
    @php
      $datavendor = [
        'vendor_logo' => $myaccount->vendor_logo,
        'vendor_name' => $myaccount->vendor_name,
        'vendor_id' => $myaccount->vendor_id
      ]
    @endphp
    <div class="uk-container">
      <vendororderlist url="{{ url('/') }}" :vendors="{{ json_encode( $datavendor ) }}" />
    </div>
  </div>
</div>
@endsection
