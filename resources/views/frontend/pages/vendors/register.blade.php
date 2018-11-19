@extends('frontend/master')
@section('headtitle', 'Garden Buana - Gabung sebagai Vendor')
@section('maincontent')
@include('frontend.includes.navbar-white')
<registervendor url="{{ url('/') }}" />
@endsection
