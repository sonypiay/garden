@extends('frontend/master')
@section('headtitle', 'Daftar Transaksi')
@section('maincontent')
@include('frontend.includes.navbar-white')
<div class="uk-container">
  @if( $myaccount->vendor_verified === 'N' )
  <div class="uk-margin-top uk-alert-warning" uk-alert>
    Akun Anda belum terverifikasi. Silahkan periksa kembali email inbox/spam Anda untuk verifikasi akun.
  </div>
  @endif
  @php
    $datavendor = [
      'vendor_logo' => $myaccount->vendor_logo,
      'vendor_name' => $myaccount->vendor_name,
      'vendor_id' => $myaccount->vendor_id,
      'kabupaten' => $myaccount->nama_kab,
      'provinsi' => $myaccount->nama_provinsi
    ]
  @endphp
  <vendorsummaryorder url="{{ url('/') }}" :orders="{{ json_encode( $results ) }}" :vendors="{{ json_encode( $datavendor ) }}" />
</div>
@endsection
