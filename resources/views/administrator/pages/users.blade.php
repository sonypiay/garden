@extends('administrator.master')
@section('headtitle', 'Garden Pages | Users')
@section('main_content')
<div class="uk-container">
  <cpusers-section url="{{ url('/cp') }}"></cpusers-section>
</div>
@endsection
