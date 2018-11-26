@extends('frontend/master')
@section('headtitle', 'Rekening Bank - ' . $myaccount->customer_name)
@section('maincontent')
@include('frontend.includes.navbar-white')
<div class="uk-grid-small" uk-grid>
  <div class="uk-width-1-6@xl uk-width-1-5@l uk-width-1-4@m uk-visible@s">
    @include('frontend.includes.customers.navsettingprofil')
  </div>
  <div class="uk-width-expand">
    <div class="uk-container">

    </div>
  </div>
</div>
@endsection
