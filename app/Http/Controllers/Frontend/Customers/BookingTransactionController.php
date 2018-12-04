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
}
