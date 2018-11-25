@extends('frontend/master')
@section('headtitle', 'Garden Buana - Vendor')
@section('maincontent')
@include('frontend.includes.navbar-white')
<loginvendor url="{{ url('/') }}" />
@endsection
