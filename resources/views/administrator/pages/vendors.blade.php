@extends('administrator.master')
@section('headtitle', 'Garden Pages | Users')
@section('main_content')
<div class="uk-container">
  <cpvendor-section url="{{ url('/cp') }}" :kabupaten="{{ json_encode( $kabupaten ) }}" />
</div>
@endsection
