@extends('frontend.master')
@section('headtitle', 'Garden Buana - Pesan Vendor')
@section('maincontent')
@include('frontend.includes.navbar-white')
<bookingvendor url="{{ url('/') }}" :customers="{{ json_encode( $myaccount ) }}" :vendors="{{ json_encode( $vendor ) }}"></bookingvendor>
@endsection
