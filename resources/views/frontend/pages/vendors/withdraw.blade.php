@extends('frontend/master')
@section('headtitle', 'Garden Buana | Penarikan Dana')
@section('maincontent')
@include('frontend.includes.navbar-white')
@php
  $datavendor = [
    'credits' => $myaccount->credits_balance,
    'vendor_id' => $myaccount->vendor_id
  ]
@endphp
<div class="uk-container">
  <withdrawvendor url="{{ url('/') }}" :vendors="{{ json_encode($datavendor) }}" :vendorbank="{{ json_encode( $vendorbank ) }}" />
</div>
@endsection
