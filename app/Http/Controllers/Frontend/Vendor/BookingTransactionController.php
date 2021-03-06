<?php

namespace App\Http\Controllers\Frontend\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\FunctionApp\CustomFunction;
use App\Database\Provinsi;
use App\Database\Kabupaten;
use App\Database\Vendors;
use App\Database\VendorReport;
use App\Database\Customers;
use App\Database\BankPayment;
use App\Database\BookingTransaction;
use App\Database\PaymentOrderVerify;
use App\Database\LogStatusTransaction;
use App\Http\Controllers\Controller;

class BookingTransactionController extends Controller
{
  use CustomFunction;

  public function index( Request $request, Vendors $vendors )
  {
    if( Cookie::get('hasLoginVendor') )
    {
      $datavendor = $this->getvendors( $vendors, Cookie::get('vendor_id') );
      $data = [
        'request' => $request,
        'sessiondata' => Cookie::get(),
        'myaccount' => $datavendor
      ];
      return response()->view('frontend.pages.vendors.orders.order_list', $data);
    }
    else
    {
      return response()->view('frontend.pages.customers.login', [
        'request' => $request
      ]);
    }
  }

  public function data_orderlist( Request $request, BookingTransaction $booking, Vendors $vendors )
  {
    $rows = $request->rows;
    $status = $request->status;
    $query = $booking->select(
      'customers.customer_name',
      'customers.customer_id',
      'booking_transaction.id',
      'booking_transaction.transaction_id',
      'booking_transaction.schedule_date',
      'booking_transaction.region',
      'booking_transaction.district',
      'booking_transaction.subdistrict',
      'booking_transaction.address',
      'booking_transaction.zipcode',
      'booking_transaction.mobile_number',
      'booking_transaction.price_deal',
      'booking_transaction.layout_design',
      'booking_transaction.additional_info',
      'booking_transaction.payment_method',
      'booking_transaction.last_status_transaction',
      'booking_transaction.customer_id',
      'booking_transaction.isPremium',
      'payment_order_verify.payment_to',
      'payment_order_verify.status_payment',
      'payment_order_verify.payment_id',
      'kabupaten.nama_kab'
    )
    ->join('payment_order_verify', 'booking_transaction.transaction_id', '=', 'payment_order_verify.transaction_id')
    ->join('customers', 'booking_transaction.customer_id', '=', 'customers.customer_id')
    ->join('kabupaten', 'booking_transaction.district', '=', 'kabupaten.id_kab');
    if( $status == 'all' )
    {
      $query = $query->where('booking_transaction.vendor_id', '=', Cookie::get('vendor_id'));
    }
    else
    {
      $query = $query->where([
        ['booking_transaction.vendor_id', '=', Cookie::get('vendor_id')],
        ['booking_transaction.last_status_transaction', '=', $status]
      ]);
    }
    $results = $query->orderBy('booking_transaction.created_at', 'desc')->paginate( $rows );
    return response()->json( $results );
  }

  public function summary_order( Request $request, BookingTransaction $booking, Vendors $vendors, $orderid )
  {
    $results = $booking->select(
      'customers.customer_name',
      'customers.customer_id',
      'booking_transaction.id',
      'booking_transaction.transaction_id',
      'booking_transaction.schedule_date',
      'booking_transaction.region',
      'booking_transaction.district',
      'booking_transaction.subdistrict',
      'booking_transaction.address',
      'booking_transaction.zipcode',
      'booking_transaction.mobile_number',
      'booking_transaction.price_deal',
      'booking_transaction.layout_design',
      'booking_transaction.additional_info',
      'booking_transaction.payment_method',
      'booking_transaction.isPremium',
      'booking_transaction.last_status_transaction',
      'booking_transaction.created_at',
      'payment_order_verify.payment_to',
      'payment_order_verify.status_payment',
      'payment_order_verify.payment_id',
      'bankpayment.bank_id',
      'bankpayment.bank_code',
      'bankpayment.bank_name',
      'bankpayment.account_number',
      'kecamatan.nama_kec',
      'kabupaten.nama_kab',
      'provinsi.nama_provinsi'
    )
    ->leftJoin('payment_order_verify', 'booking_transaction.transaction_id', '=', 'payment_order_verify.transaction_id')
    ->leftJoin('bankpayment', 'payment_order_verify.payment_to', '=', 'bankpayment.bank_id')
    ->join('customers', 'booking_transaction.customer_id', '=', 'customers.customer_id')
    ->join('kabupaten', 'booking_transaction.district', '=', 'kabupaten.id_kab')
    ->join('provinsi', 'kabupaten.id_provinsi', '=', 'provinsi.id_provinsi')
    ->join('kecamatan', 'kabupaten.id_kab', '=', 'kecamatan.id_kab')
    ->where('booking_transaction.transaction_id', $orderid);
    if( $results->count() == 0 ) abort(404);

    if( Cookie::get('hasLoginVendor') )
    {
      $datavendor = $vendors->join('kabupaten', 'vendors.vendor_district', '=', 'kabupaten.id_kab')
      ->join('provinsi', 'kabupaten.id_provinsi', '=', 'provinsi.id_provinsi')
      ->where('vendors.vendor_id', '=', Cookie::get('vendor_id'))
      ->first();

      $data = [
        'request' => $request,
        'sessiondata' => Cookie::get(),
        'myaccount' => $datavendor,
        'results' => $results->first()
      ];
      return response()->view('frontend.pages.vendors.orders.summary_order', $data);
    }
    else
    {
      return response()->view('frontend.pages.vendors.login', [
        'request' => $request
      ]);
    }
  }

  public function approval_order( Request $request, BookingTransaction $booking, LogStatusTransaction $logstatus, $orderid )
  {
    $approval = $request->approval;
    $update = $booking->where('transaction_id', '=', $orderid)
    ->first();
    if( $approval === 'Y' )
    {
      $logstatus = new $logstatus;
      $update->last_status_transaction = 'payment_waiting';

      $logstatus->transaction_id = $orderid;
      $logstatus->status_transaction = 'payment_waiting';
      $logstatus->status_description = 'Pesanan diterima oleh pihak Vendor. <br> Menunggu pembayaran dari sisi Pelanggan.';
      $res = [
        'status' => 200,
        'statusText' => 'Approved'
      ];
    }
    else
    {
      $logstatus = new $logstatus;
      $update->last_status_transaction = 'rejected';

      $logstatus->transaction_id = $orderid;
      $logstatus->status_transaction = 'rejected';
      $logstatus->status_description = 'Pesanan ditolak oleh pihak Vendor.';
      $res = [
        'status' => 200,
        'statusText' => 'Rejected'
      ];
    }
    $logstatus->log_date = date('Y-m-d H:i:s');
    $logstatus->save();
    $update->save();

    return response()->json( $res, $res['status'] );
  }

  public function process_order( Request $request, BookingTransaction $booking, LogStatusTransaction $logstatus, $orderid )
  {
    $booking = $booking->where('transaction_id', $orderid)->first();
    $logstatus = new $logstatus;
    $booking->last_status_transaction = 'process';
    $booking->save();

    $logstatus->transaction_id = $orderid;
    $logstatus->status_transaction = 'process';
    $logstatus->status_description = 'Pesanan sedang diproses oleh pihak Vendor';
    $logstatus->log_date = date('Y-m-d H:i:s');
    $logstatus->save();

    $res = [
      'status' => 200,
      'statusText' => 'Success'
    ];
    return response()->json( $res, $res['status'] );
  }

  public function progress_order( Request $request, BookingTransaction $booking, LogStatusTransaction $logstatus, $orderid )
  {
    $booking = $booking->where('transaction_id', $orderid)->first();
    $logstatus = new $logstatus;
    $booking->last_status_transaction = 'onprogress';
    $booking->save();

    $logstatus->transaction_id = $orderid;
    $logstatus->status_transaction = 'onprogress';
    $logstatus->status_description = 'Pesanan sedang dikerjakan';
    $logstatus->log_date = date('Y-m-d H:i:s');
    $logstatus->save();

    $res = [
      'status' => 200,
      'statusText' => 'Success'
    ];
    return response()->json( $res, $res['status'] );
  }

  public function createreport( Request $request, BookingTransaction $booking, LogStatusTransaction $logstatus, VendorReport $report, $orderid )
  {
    $filereport = $request->filereport;
    $deskripsi = $request->deskripsi;
    $extension = $filereport->getClientOriginalExtension();
    $filename = date('Ymd') . '_' . hash('crc32b', bin2hex( $filereport->getClientOriginalName() ) ) . '.' . $extension;
    $booking = $booking->where('transaction_id', $orderid)->first();
    $logstatus = new $logstatus;
    $report = new $report;
    $storage = Storage::disk('imagestorage');

    $status = 'report';
    $booking->last_status_transaction = $status;
    $booking->save();

    $logstatus->transaction_id = $orderid;
    $logstatus->status_transaction = $status;
    $logstatus->status_description = 'Laporan hasil pekerjaan terlampir.';
    $logstatus->log_date = date('Y-m-d H:i:s');
    $logstatus->save();

    $report->report_file = $filename;
    $report->report_description = $deskripsi;
    $report->transaction_id = $orderid;
    $report->save();

    $storage->putFileAs('vendor/reports', $filereport, $filename);

    $res = [
      'status' => 200,
      'statusText' => 'Laporan berhasil dilampirkan'
    ];

    return response()->json( $res, $res['status'] );
  }
}
