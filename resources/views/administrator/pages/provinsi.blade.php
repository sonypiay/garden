@extends('administrator.master')
@section('headtitle', 'Garden Pages - Provinsi')
@section('main_content')
<div class="uk-container">
  <provinsi-section url="{{ url('/cp/management') }}" />
</div>
@endsection
