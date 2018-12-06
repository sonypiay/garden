@extends('frontend.master')
@section('headtitle', 'Garden Buana - Konfirmasi Pesanan')
@section('maincontent')
@include('frontend.includes.navbar-white')
<customersummaryorder
url="{{ url('/') }}"
:orders="{{ json_encode( $results ) }}"></customersummaryorder>
@endsection
