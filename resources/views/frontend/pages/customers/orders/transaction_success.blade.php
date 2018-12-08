@extends('frontend.master')
@section('headtitle', 'Garden Buana - Transaksi Berhasil')
@section('maincontent')
<div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s uk-align-center">
  <div class="uk-margin-large-top summary-transaction-logo">
    <img class="uk-width-1-4 uk-align-center" src="{{ asset('images/logobrand/gplogo-primary.png') }}" alt="">
  </div>
  <div class="uk-card uk-card-body uk-card-default summary-transaction-content">
    <div class="uk-card-title summary-transaction-title">Transaksi Berhasil</div>
    <div class="uk-grid-small uk-grid-match" uk-grid>
      <div class="uk-width-expand">
        <div class="summary-transaction-contentleft">
          <div class="uk-margin-top summary-transaction-detail">
            <div class="uk-margin-top summary-transaction-detail-verification">
              Pembayaran Anda akan kami verifikasi terlebih dahulu oleh tim Garden Buana.
            </div>
            <div class="uk-margin-top summary-transaction-detail-thankyou">Terima kasih telah memesan melalui Garden Buana</div>
          </div>
        </div>
      </div>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@">
        <div class="summary-transaction-contentright">
          <div class="uk-width-1-1 uk-tile uk-tile-default">
            <div class="uk-width-1-1 uk-position-center">
              <a class="uk-width-1-1 uk-button uk-button-default summary-transaction-viewdetail" href="{{ route('summaryordercustomer_page', ['orderid' => $results->transaction_id]) }}">Lihat rincian</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
