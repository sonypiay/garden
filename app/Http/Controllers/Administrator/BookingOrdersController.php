<?php

namespace App\Http\Controllers\Administrator;

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

class BookingOrdersController extends Controller
{
  use CustomFunction;

  public function index( Request $request )
  {
    if( Cookie::get('hasLoginPanel') )
    {
      return response()->view('administrator.pages.orderlist', [
        'request' => $request,
        'getSession' => $request->session(),
        'getCookies' => $request->cookie()
      ]);
    }
    else
    {
      return redirect( route('loginadminpage') );
    }
  }

  public function data_orderlist( Request $request, BookingTransaction $booking )
  {
    $rows = $request->rows;
    $keywords = $request->keywords;
    $status = $request->status;
    $premium = $request->premium;

    $query = $booking->select(
      'vendors.vendor_name',
      'vendors.vendor_id',
      'customers.customer_id',
      'customers.customer_name',
      'booking_transaction.id',
      'booking_transaction.transaction_id',
      'booking_transaction.schedule_date',
      'booking_transaction.address',
      'booking_transaction.zipcode',
      'booking_transaction.mobile_number',
      'booking_transaction.price_deal',
      'booking_transaction.layout_design',
      'booking_transaction.additional_info',
      'booking_transaction.payment_method',
      'booking_transaction.last_status_transaction',
      'booking_transaction.isPremium',
      'booking_transaction.created_at',
      'payment_order_verify.payment_to',
      'payment_order_verify.status_payment',
      'payment_order_verify.payment_id',
      'payment_order_verify.payment_amount',
      'bankpayment.bank_id',
      'bankpayment.bank_code',
      'bankpayment.bank_name',
      'bankpayment.account_number'
    )
    ->leftJoin('payment_order_verify', 'booking_transaction.transaction_id', '=', 'payment_order_verify.transaction_id')
    ->leftJoin('bankpayment', 'payment_order_verify.payment_to', '=', 'bankpayment.bank_id')
    ->join('vendors', 'booking_transaction.vendor_id', '=', 'vendors.vendor_id')
    ->join('customers', 'booking_transaction.customer_id', '=', 'customers.customer_id');

    if( empty( $keywords ) )
    {
      if( $status == 'all' )
      {
        if( $premium == 'all' )
        {
          $query = $query->orderBy('booking_transaction.created_at');
        }
        else
        {
          $query = $query->where('booking_transaction.isPremium', '=', $premium)
          ->orderBy('booking_transaction.created_at');
        }
      }
      else
      {
        if( $premium == 'all' )
        {
          $query = $query->where('booking_transaction.last_status_transaction', '=', $status);
        }
        else
        {
          $query = $query->where([
            ['booking_transaction.last_status_transaction', '=', $status],
            ['booking_transaction.isPremium', '=', $premium]
          ]);
        }
      }
    }
    else
    {
      if( $status == 'all' )
      {
        if( $premium == 'all' )
        {
          $query = $query->where('booking_transaction.transaction_id', 'like', '%' . $keywords . '%')
          ->orWhere('customers.customer_name', 'like', '%' . $keywords . '%')
          ->orWhere('vendors.vendor_name', 'like', '%' . $keywords . '%');
        }
        else
        {
          $query = $query->where([
            ['booking_transaction.transaction_id', 'like', '%' . $keywords . '%'],
            ['booking_transaction.isPremium', '=', $premium]
          ])
          ->orWhere([
            ['customers.customer_name', 'like', '%' . $keywords . '%'],
            ['booking_transaction.isPremium', '=', $premium]
          ])
          ->orWhere([
            ['vendors.vendor_name', 'like', '%' . $keywords . '%'],
            ['booking_transaction.isPremium', '=', $premium]
          ]);
        }
      }
      else
      {
        if( $premium == 'all' )
        {
          $query = $query->where([
            ['booking_transaction.transaction_id', 'like', '%' . $keywords . '%'],
            ['booking_transaction.last_status_transaction', '=', $status]
          ])
          ->orWhere([
            ['customers.customer_name', 'like', '%' . $keywords . '%'],
            ['booking_transaction.last_status_transaction', '=', $status]
          ])
          ->orWhere([
            ['vendors.vendor_name', 'like', '%' . $keywords . '%'],
            ['booking_transaction.last_status_transaction', '=', $status]
          ]);
        }
        else
        {
          $query = $query->where([
            ['booking_transaction.transaction_id', 'like', '%' . $keywords . '%'],
            ['booking_transaction.last_status_transaction', '=', $status],
            ['booking_transaction.isPremium', '=', $premium]
          ])
          ->orWhere([
            ['customers.customer_name', 'like', '%' . $keywords . '%'],
            ['booking_transaction.last_status_transaction', '=', $status],
            ['booking_transaction.isPremium', '=', $premium]
          ])
          ->orWhere([
            ['vendors.vendor_name', 'like', '%' . $keywords . '%'],
            ['booking_transaction.last_status_transaction', '=', $status],
            ['booking_transaction.isPremium', '=', $premium]
          ]);
        }
      }
    }

    $results = $query->orderBy('booking_transaction.created_at')->paginate( $rows );
    return response()->json( $results );
  }

  public function view_transaction( Request $request, BookingTransaction $booking, LogStatusTransaction $logstatus, $orderid )
  {
    $query = $booking->select(
      'kecamatan.nama_kec',
      'kabupaten.nama_kab',
      'provinsi.nama_provinsi'
    )
    ->join('kabupaten', 'booking_transaction.district', '=', 'kabupaten.id_kab')
    ->join('provinsi', 'booking_transaction.region', '=', 'provinsi.id_provinsi')
    ->join('kecamatan', 'booking_transaction.subdistrict', '=', 'kecamatan.id_kec')
    ->where('booking_transaction.transaction_id', '=', $orderid)->first();

    $logstatus = $logstatus->where('transaction_id', '=', $orderid)
    ->orderBy('log_date',' asc');

    $data = [
      'logstatus' => [
        'total' => $logstatus->count(),
        'results' => $logstatus->get()
      ],
      'location' => [
        'kecamatan' => $query->nama_kec,
        'kabupaten' => $query->nama_kab,
        'provinsi' => $query->nama_provinsi
      ]
    ];

    return response()->json( $data );
  }

  public function update( Request $request, BookingTransaction $booking, LogStatusTransaction $logstatus, $orderid )
  {
    $value = $request->value;
    $booking = $booking->where('transaction_id', $orderid)->first();
    $logstatus = new $logstatus;
    if( $value == 'accept' )
    {
      $booking->last_status_transaction = 'paid';
      $logstatus->transaction_id = $orderid;
      $logstatus->status_description = 'Pembayaran telah diterima Garden Buana dan pesanan Anda sudah diteruskan ke vendor.';
      $logstatus->status_transaction = 'paid';
    }
    else
    {
      $booking->last_status_transaction = 'cancel';
      $logstatus->transaction_id = $orderid;
      $logstatus->status_description = 'Pesanan dibatalkan oleh Garden Buana';
      $logstatus->status_transaction = 'cancel';
    }
    $logstatus->log_date = date('Y-m-d H:i:s');
    $booking->save();
    $logstatus->save();
    $res = [
      'status' => 200,
      'statusText' => 'success'
    ];
    return response()->json( $res, $res['status'] );
  }
}
