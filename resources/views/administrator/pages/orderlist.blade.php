@extends('administrator.master')
@section('headtitle', 'Garden Pages - Daftar Transaksi')
@section('main_content')
<div class="uk-container">
  <orderlist-section url="{{ url('/cp') }}" />
</div>
@endsection
