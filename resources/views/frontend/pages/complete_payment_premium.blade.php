@extends('frontend.master')
@section('headtitle', 'Garden Buana - Transaksi Berhasil')
@section('maincontent')
<div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s uk-align-center">
  <div class="uk-margin-large-top summary-transaction-logo">
    <img class="uk-width-1-4 uk-align-center" src="{{ asset('images/logobrand/gplogo-primary.png') }}" alt="">
  </div>
  <div class="uk-card uk-card-body uk-card-default summary-transaction-content">
    <div class="uk-card-title summary-transaction-title">Selesaikan Pembayaran</div>
    <div class="summary-transaction-amount">
      <div class="summary-transaction-paymentcode">Order ID : {{ $results->subs_order_id }}</div>
      <div class="summary-transaction-totalamount">IDR 99.000</div>
    </div>
    <div class="uk-grid-small uk-grid-match" uk-grid>
      <div class="uk-width-expand">
        <div class="summary-transaction-contentleft">
          <div class="summary-transaction-detail">
            <div class="summary-transaction-detail-verification">
              {{ $results->bank_name }}<br>
              {{ $results->account_number }}
            </div>
            <div class="uk-margin-top summary-transaction-detail-thankyou">
              Masukkan berita transfer/nomor referensi <strong>{{ $results->subs_order_id }}</strong> ketika melakukan transfer dana.
            </div>
          </div>
        </div>
      </div>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-2@s">
        <div class="summary-transaction-contentright">
          <div class="uk-width-1-1 uk-tile uk-tile-default">
            <div class="uk-width-1-1 uk-position-center">
              <a class="uk-width-1-1 uk-button uk-button-default summary-transaction-viewdetail" href="{{ route('vendorpremium_page') }}">ke Halaman Profil</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
