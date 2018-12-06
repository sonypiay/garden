<?php

namespace App\Http\Controllers\Frontend\Customers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\FunctionApp\CustomFunction;
use App\Database\Provinsi;
use App\Database\Kabupaten;
use App\Database\Vendors;
use App\Database\Customers;
use App\Database\BankPayment;
use App\Database\BookingTransaction;
use App\Database\PaymentOrderVerify;
use App\Database\LogStatusTransaction;
use App\Http\Controllers\Controller;

class BookingTransactionController extends Controller
{
  use CustomFunction;

  public function bookingpage( Request $request, Vendors $vendors, Customers $customers, $name )
  {
    if( Cookie::get('hasLoginCustomers') )
    {
      $datacustomer = $this->getcustomer( $customers, Cookie::get('customer_id') );
      $datavendor = $vendors->select(
        'vendor_id',
        'vendor_slug_name',
        'vendor_name'
      )->where('vendor_slug_name', '=', $name)->first();

      return response()->view('frontend.pages.customers.bookingvendor', [
        'request' => $request,
        'sessiondata' => $this->get_cookiescustomer(),
        'myaccount' => $datacustomer,
        'vendor' => $datavendor
      ]);
    }
    else
    {
      return response()->view('frontend.pages.customers.login', [
        'request' => $request
      ]);
    }
  }

  public function bookingprocess( Request $request, BookingTransaction $transaction, LogStatusTransaction $logstatus, PaymentOrderVerify $payment_verify )
  {
    $schedule_date = $request->schedule_date;
    $region = $request->region;
    $district = $request->district;
    $subdistrict = $request->subdistrict;
    $layout_design = $request->layout_design;
    $mobile_number = $request->mobile_number;
    $price_deal = $request->price_deal;
    $address = $request->address;
    $zipcode = $request->zipcode;
    $customer = $request->customer;
    $vendor = $request->vendor;
    $additional_info = $request->additional_info;
    $orderdate = date('Y-m-d H:i:s');
    $fetchid = $transaction->orderBy('id', 'desc')->count();
    $generate_id = str_pad( $fetchid + 1, 5, '0', STR_PAD_LEFT );
    $uniqid = strtoupper(hash('crc32b', uniqid()));
    $transactionid = 'GB' . date('Ymd') . substr($uniqid, 4, 2) . $generate_id;
    $transaction = new $transaction;
    $logstatus = new $logstatus;
    $payment_verify = new $payment_verify;
    $storage = Storage::disk('imagestorage');
    $status_type = 'payment_waiting';

    $transaction->schedule_date = $schedule_date;
    $transaction->transaction_id = $transactionid;
    $transaction->region = $region;
    $transaction->district = $district;
    $transaction->subdistrict = $subdistrict;
    $transaction->address = $address;
    $transaction->zipcode = $zipcode;
    $transaction->mobile_number = $mobile_number;
    $transaction->price_deal = $price_deal;
    $transaction->additional_info = $additional_info;
    $transaction->customer_id = $customer;
    $transaction->vendor_id = $vendor;
    //$transaction->payment_method = 'TRANSFER';
    $transaction->last_status_transaction = $status_type;
    if( ! empty( $layout_design ) )
    {
      $filename = date('Ymd') . '_' . $layout_design->getClientOriginalName();
      $storage->putFileAs('customer/layout_design', $layout_design, $filename);
      $transaction->layout_design = $filename;
    }

    $logstatus->transaction_id = $transactionid;
    $logstatus->status_transaction = $status_type;
    $logstatus->status_description = 'Melakukan proses pemesanan <br> Menunggu konfirmasi pembayaran';
    $logstatus->log_date = $orderdate;

    $payment_verify->status_payment = 'pending';
    $payment_verify->transaction_id = $transactionid;
    $payment_verify->payment_id = date('Ymd') . substr($uniqid, 4, 2);

    $transaction->save();
    $logstatus->save();
    $payment_verify->save();

    $res = [
      'status' => 200,
      'statusText' => 'Melakukan proses pemesanan',
      'transaction_id' => $transactionid
    ];

    return response()->json($res, $res['status']);
  }

  public function main_orders( Request $request, BookingTransaction $booking, Vendors $vendors, Customers $customers, BankPayment $bankpayment, $orderid )
  {
    $results = $booking->select(
      'vendors.vendor_name',
      'vendors.vendor_id',
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
    ->join('payment_order_verify', 'booking_transaction.transaction_id', '=', 'payment_order_verify.transaction_id')
    ->leftJoin('bankpayment', 'payment_order_verify.payment_to', '=', 'bankpayment.bank_id')
    ->join('vendors', 'booking_transaction.vendor_id', '=', 'vendors.vendor_id')
    ->join('kabupaten', 'booking_transaction.district', '=', 'kabupaten.id_kab')
    ->join('provinsi', 'kabupaten.id_provinsi', '=', 'provinsi.id_provinsi')
    ->join('kecamatan', 'kabupaten.id_kab', '=', 'kecamatan.id_kab')
    ->where('booking_transaction.transaction_id', $orderid)
    ->first();

    $vendorregion = $vendors->select(
      'vendors.vendor_region',
      'vendors.vendor_district',
      'kabupaten.nama_kab',
      'provinsi.nama_provinsi'
    )
    ->join('kabupaten', 'vendors.vendor_district', '=', 'kabupaten.id_kab')
    ->join('provinsi', 'kabupaten.id_provinsi', '=', 'provinsi.id_provinsi')
    ->where('vendors.vendor_id', $results->vendor_id)->first();

    if( Cookie::get('hasLoginCustomers') )
    {
      $datacustomer = $this->getcustomer( $customers, Cookie::get('customer_id') );
      $data = [
        'request' => $request,
        'sessiondata' => $this->get_cookiescustomer(),
        'myaccount' => $datacustomer,
        'results' => $results,
        'vendor_region' => $vendorregion,
        'bankpayment' => $bankpayment->select('bank_id','bank_code','bank_name', 'account_number')->orderBy('bank_name', 'asc')->get()
      ];
      return response()->view('frontend.pages.customers.orders.main_orders', $data);
    }
    else
    {
      return response()->view('frontend.pages.customers.login', [
        'request' => $request
      ]);
    }
  }

  public function booking_checkout( Request $request, BookingTransaction $booking, LogStatusTransaction $logstatus, PaymentOrderVerify $payment_verify, $orderid )
  {
    $payment_id = $request->payment_id;
    $bank = $request->bank;
    $payment_method = $request->payment_method;
    $status_transaction = 'payment_verify';
    $booking = $booking->where('transaction_id', $orderid)->first();
    $logstatus = new $logstatus;
    $payment_verify = $payment_verify->where([
        ['transaction_id', '=', $orderid],
        ['payment_id', '=', $payment_id]
    ])->first();
    $booking->payment_method = $payment_method;
    $booking->last_status_transaction = $status_transaction;
    $booking->save();

    $logstatus->transaction_id = $orderid;
    $logstatus->status_transaction = $status_transaction;
    $logstatus->status_description = 'Menunggu proses pembayaran verifikasi pihak ketiga.';
    $logstatus->log_date = date('Y-m-d H:i:s');
    $logstatus->save();

    $payment_verify->payment_to = $bank;
    $payment_verify->status_payment = 'verification';
    $payment_verify->save();

    $res = [
      'status' => 200,
      'statusText' => 'Transaksi ' . $orderid . ' berhasil dilakukan.'
    ];

    return response()->json( $res, $res['status'] );
  }

  public function booking_transaction_success( Request $request, Customers $customers, BookingTransaction $booking, BankPayment $bankpayment, $orderid )
  {
    $booking = $booking->join('payment_order_verify', 'booking_transaction.transaction_id', '=', 'payment_order_verify.transaction_id')
    ->where('booking_transaction.transaction_id', $orderid);
    if( $booking->count() == 0 ) abort(404);
    $results = $booking->first();

    if( Cookie::get('hasLoginCustomers') )
    {
      $datacustomer = $this->getcustomer( $customers, Cookie::get('customer_id') );
      $data = [
        'request' => $request,
        'sessiondata' => $this->get_cookiescustomer(),
        'myaccount' => $datacustomer,
        'results' => $results,
        'bankpayment' => $bankpayment->select('bank_id','bank_code','bank_name')->orderBy('bank_name', 'asc')->get()
      ];
      return response()->view('frontend.pages.customers.orders.transaction_success', $data);
    }
    else
    {
      return response()->view('frontend.pages.customers.login', [
        'request' => $request
      ]);
    }
  }

  public function summary_order( Request $request, BookingTransaction $booking, Customers $customers, $orderid )
  {
    $results = $booking->select(
      'vendors.vendor_name',
      'vendors.vendor_id',
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
    ->join('payment_order_verify', 'booking_transaction.transaction_id', '=', 'payment_order_verify.transaction_id')
    ->join('bankpayment', 'payment_order_verify.payment_to', '=', 'bankpayment.bank_id')
    ->join('vendors', 'booking_transaction.vendor_id', '=', 'vendors.vendor_id')
    ->join('kabupaten', 'booking_transaction.district', '=', 'kabupaten.id_kab')
    ->join('provinsi', 'kabupaten.id_provinsi', '=', 'provinsi.id_provinsi')
    ->join('kecamatan', 'kabupaten.id_kab', '=', 'kecamatan.id_kab')
    ->where('booking_transaction.transaction_id', $orderid);
    if( $results->count() == 0 ) abort(404);

    if( Cookie::get('hasLoginCustomers') )
    {
      $datacustomer = $this->getcustomer( $customers, Cookie::get('customer_id') );
      $data = [
        'request' => $request,
        'sessiondata' => $this->get_cookiescustomer(),
        'myaccount' => $datacustomer,
        'results' => $results->first()
      ];
      return response()->view('frontend.pages.customers.orders.summary_order', $data);
    }
    else
    {
      return response()->view('frontend.pages.customers.login', [
        'request' => $request
      ]);
    }
  }
}
