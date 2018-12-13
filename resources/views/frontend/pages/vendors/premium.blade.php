@extends('frontend/master')
@section('headtitle', 'Garden Buana - ' . $myaccount->vendor_name)
@section('maincontent')
@include('frontend.includes.navbar-white')
<div class="uk-grid-collapse" uk-grid>
  <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-4@m uk-visible@s">
    @include('frontend.includes.vendors.navvendor')
  </div>
  <div class="uk-width-expand">
    <div class="uk-container uk-margin-top">
      @include('frontend.includes.vendors.navsettingaccount')
      <vendoreditaccount pages="premiumpage" url="{{ url('/') }}" :bankcustomer="{{ json_encode( $bankcustomer ) }}" />
    </div>
  </div>
</div>
@endsection
