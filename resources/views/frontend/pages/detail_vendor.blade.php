@extends('frontend/master')
@section('headtitle', $vendor->vendor_name)
@section('maincontent')
@include('frontend.includes.navbar-white')
<div class="uk-container">
  <getdetailvendor url="{{ url('/') }}" :vendors="{{ json_encode( $vendor ) }}" :session="{{ json_encode( $sessiondata ) }}"></getdetailvendor>
</div>
@endsection
