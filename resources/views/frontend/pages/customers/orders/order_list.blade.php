@extends('frontend.master')
@section('headtitle', 'Garden Buana - Konfirmasi Pesanan')
@section('maincontent')
@include('frontend.includes.navbar-white')
<div class="uk-grid-small" uk-grid>
  <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-4@m uk-visible@s">
    @include('frontend.includes.customers.navcustomers')
  </div>
  <div class="uk-width-expand">
    <div class="uk-container">
      <customerorderlist url="{{ url('/') }}"></customerorderlist>
    </div>
  </div>
</div>
@endsection
