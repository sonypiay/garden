@extends('frontend.master')
@section('headtitle', 'Garden Buana - ' . $myaccount->customer_name)
@section('maincontent')
@include('frontend.includes.navbar-white')
<customerdashboard url="{{ url('/') }}" :customers="{{ json_encode( $myaccount ) }}"></customerdashboard>
@endsection
