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
use App\Database\BookingTransaction;
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

  public function bookingprocess( Request $request, BookingTransaction $transaction, LogStatusTransaction $logstatus )
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
    $transactionid = 'GB' . date('Ymd') . $uniqid . $generate_id;
    $transaction = new $transaction;
    $logstatus = new $logstatus;

    return response()->json([
      'id' => $transactionid
    ]);
  }
}
