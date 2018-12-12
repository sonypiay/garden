@extends('frontend/master')
@section('headtitle', 'Garden Buana | Rincian Pesanan')
@section('maincontent')
@include('frontend.includes.navbar-white')
@php
  $datavendor = [
    'vendor_logo' => $myaccount->vendor_logo,
    'vendor_name' => $myaccount->vendor_name,
    'vendor_id' => $myaccount->vendor_id,
    'kabupaten' => $myaccount->nama_kab,
    'provinsi' => $myaccount->nama_provinsi
  ]
@endphp
<vendorsummaryorder url="{{ url('/') }}" :orders="{{ json_encode( $results ) }}" :vendors="{{ json_encode( $datavendor ) }}" />
@endsection
