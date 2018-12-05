@extends('frontend.master')
@section('headtitle', 'Garden Buana - Konfirmasi Pesanan')
@section('maincontent')
@include('frontend.includes.navbar-white')
<customermainorder
url="{{ url('/') }}"
:orders="{{ json_encode( $results ) }}"
:vendors="{{ json_encode( $vendor_region ) }}"
:bankpayment="{{ json_encode( $bankpayment ) }}"></customermainorder>
@endsection
