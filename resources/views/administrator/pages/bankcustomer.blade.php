@extends('administrator.master')
@section('headtitle', 'Garden Pages - Bank Customer')
@section('main_content')
<div class="uk-container">
  <cpbankcustomer-section url="{{ url('/cp/management') }}"></cpbankcustomer-section>
</div>
@endsection
