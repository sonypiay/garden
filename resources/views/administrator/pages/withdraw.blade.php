@extends('administrator.master')
@section('headtitle', 'Garden Pages | Withdraw')
@section('main_content')
<div class="uk-container">
  <withdraw-section url="{{ url('/cp') }}" />
</div>
@endsection
