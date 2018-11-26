@extends('frontend/master')
@section('headtitle', 'Ubah Email - ' . $myaccount->customer_name)
@section('maincontent')
@include('frontend.includes.navbar-white')
<div class="uk-grid-small" uk-grid>
  <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-4@m uk-visible@s">
    @include('frontend.includes.customers.navsettingprofil')
  </div>
  <div class="uk-width-expand">
    <div class="uk-container">
      <customereditaccount url="{{ url('/') }}" page="editemail" :customers="{{ json_encode( $myaccount ) }}"></customereditaccount>
    </div>
  </div>
</div>
@endsection
