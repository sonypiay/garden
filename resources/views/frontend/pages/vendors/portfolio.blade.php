@extends('frontend/master')
@section('headtitle', 'Garden Buana - ' . $myaccount->vendor_name)
@section('maincontent')
@include('frontend.includes.navbar-white')
<div class="uk-grid-small" uk-grid>
  <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-4@m uk-visible@s">
    @include('frontend.includes.vendors.navvendor')
  </div>
  <div class="uk-width-expand">
    <div class="uk-container">
      <vendorportfolio url="{{ url('/') }}" />
    </div>
  </div>
</div>
@endsection
