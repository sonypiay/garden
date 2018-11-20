@extends('administrator.master')
@section('headtitle', 'Garden Pages - Kabupaten')
@section('main_content')
<div class="uk-container">
  <kabupaten-section url="{{ url('/cp/management') }}" :provinsi="{{ json_encode( $provinsi ) }}" />
</div>
@endsection
