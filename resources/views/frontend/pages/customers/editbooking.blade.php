@extends('frontend.master')
@section('headtitle', 'Garden Buana - Edit Pesanan')
@section('maincontent')
@include('frontend.includes.navbar-white')
<editbookingvendor url="{{ url('/') }}" :booking="{{ json_encode( $booking ) }}"></editbookingvendor>
@endsection
