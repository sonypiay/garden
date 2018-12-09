@extends('frontend.master')
@section('headtitle', 'Garden Buana - Konfirmasi Pesanan')
@section('maincontent')
@include('frontend.includes.navbar-white')
@if( $results->last_status_transaction == 'approval' or $results->last_status_transaction === 'payment_waiting' )
<customermainorder
url="{{ url('/') }}"
:orders="{{ json_encode( $results ) }}"
:vendors="{{ json_encode( $vendor_region ) }}"
:bankpayment="{{ json_encode( $bankpayment ) }}"></customermainorder>
@else
<script type="text/javascript">
  document.location = "{{ route('summaryordercustomer_page', ['orderid' => $results->transaction_id]) }}";
</script>
@endif
@endsection
