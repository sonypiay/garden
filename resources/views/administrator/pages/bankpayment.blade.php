@extends('administrator.master')
@section('headtitle', 'Garden Pages - Bank Payment')
@section('main_content')
<div class="uk-container">
  <cpbankpayment-section url="{{ url('/cp/management') }}"></cpbankpayment-section>
</div>
@endsection
