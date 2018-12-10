@extends('frontend/master')
@section('headtitle', 'Garden Pages - Platform Pemesanan Jasa Tukang Kebun')
@section('maincontent')
@include('frontend.includes.navbar-white')
<div class="uk-cover-container coverbg">
  <img src="{{ asset('/images/banner/Banner2.jpg') }}" alt="" uk-cover>
  <div class="uk-overlay uk-overlay-primary uk-position-cover coverbg-overlay">
    <div class="uk-position-bottom-left coverbg-heading">
      Vendor
    </div>
  </div>
</div>
<div class="uk-container">
  <discoveryvendor url="{{ url('/') }}"></discoveryvendor>
</div>
@endsection
