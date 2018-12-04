@extends('frontend/master')
@section('headtitle', $myaccount->vendor_name)
@section('maincontent')
@include('frontend.includes.navbar-white')
<div class="uk-container">
  <getdetailvendor url="{{ url('/') }}" :vendors="{{ json_encode( $vendor ) }}"></getdetailvendor>
</div>
@endsection