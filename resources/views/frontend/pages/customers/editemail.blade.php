@extends('frontend/master')
@section('headtitle', 'Ubah Email - ' . $myaccount->customer_name)
@section('maincontent')
@include('frontend.includes.navbar-white')
<div class="uk-container uk-margin-large-top">
  <div class="uk-grid-medium" uk-grid>
    <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-visible@s">
      @include('frontend.includes.customers.navsettingprofil')
    </div>
    <div class="uk-width-expand">
      <customereditaccount url="{{ url('/') }}" page="editemail" :customers="{{ json_encode( $myaccount ) }}"></customereditaccount>
    </div>
  </div>
</div>
@endsection
