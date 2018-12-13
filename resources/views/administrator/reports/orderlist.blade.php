<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    @include('administrator.includes.meta-header')
    <title>Laporan Pemesanan</title>
  </head>
<body>
  <div class="uk-container">
    <div class="uk-margin-large-top">
      <div class="uk-width-1-6 uk-align-center">
        <img class="uk-width-1-2" src="{{ asset('images/logobrand/gplogo-primary-new.png') }}" alt="">
      </div>
      <h3>Laporan Transaksi Pemesanan</h3>
      @php
        $statusTransaction = [
          'approval' => 'Menunggu Diterima',
          'approved' => 'Pesanan Diterima',
          'rejected' => 'Pesanan ditolak',
          'pending' => 'Pesanan ditunda',
          'payment_waiting' => 'Menunggu Pembayaran',
          'payment_verify' => 'Verifikasi Pembayaran',
          'paid' => 'Dibayar',
          'process' => 'Sedang diproses',
          'onprogress' => 'Sedang dikerjakan',
          'report' => 'Laporan Terlampir',
          'done' => 'Selesai',
          'cancel' => 'Pesanan Dibatalkan'
        ]
      @endphp
      <table class="uk-table uk-table-hover uk-table-divider uk-table-small uk-table-justify">
        <thead>
          <tr>
            <th>No. Transaksi</th>
            <th>Pelanggan</th>
            <th>Vendor</th>
            <th>Status Pesanan</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          @foreach( $results as $res )
            <tr>
              <td>{{ $res->transaction_id }}</td>
              <td>{{ $res->customer_name }}</td>
              <td>{{ $res->vendor_name }}</td>
              <td>{{ $statusTransaction[$res->last_status_transaction] }}</td>
              <td>
                @php $orderdate = new DateTime( $res->created_at ) @endphp
                {{ $orderdate->format('F d, Y H:i:s') }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
