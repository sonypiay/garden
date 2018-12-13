@extends('frontend/master')
@section('headtitle', 'Garden Buana | Baca Pesan')
@section('maincontent')
@include('frontend.includes.navbar-white')
<div class="uk-container">
  <messagevendor url="{{ url('/') }}" pages="readmessage" />
</div>
@endsection
