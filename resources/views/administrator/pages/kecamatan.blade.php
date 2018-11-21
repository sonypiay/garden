@extends('administrator.master')
@section('headtitle', 'Garden Pages - Kabupaten')
@section('main_content')
<div class="uk-container">
  <kecamatan-section url="{{ url('/cp/management') }}" :kabupaten="{{ json_encode( $kabupaten ) }}" />
</div>
@endsection
