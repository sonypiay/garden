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
}
