<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\FunctionApp\CustomFunction;
use App\Database\Vendors;
use App\Database\VendorPortfolio;
use App\Database\Customers;
use App\Database\BookingTransaction;
use App\Http\Controllers\Controller;

class DiscoveryVendor extends Controller
{
  use CustomFunction;

  public function index( Request $request, Vendors $vendors, Customers $customers )
  {
    if( Cookie::get('hasLoginCustomer') )
    {
      $customer = $this->getcustomer( $customers, Cookie::get('customer_id') );
      $data = [
        'request' => $request,
        'hasLogin' => true,
        'users' => $customer,
        'sessiondata' => Cookie::get()
      ];
    }
    else if( Cookie::get('hasLoginVendor') )
    {
      $vendors = $this->getcustomer( $vendors, Cookie::get('vendor_id') );
      $data = [
        'request' => $request,
        'hasLogin' => true,
        'users' => $vendors,
        'sessiondata' => Cookie::get()
      ];
    }
    else
    {
      $data = [
        'request' => $request,
        'hasLogin' => false,
        'users' => null,
        'sessiondata' => Cookie::get()
      ];
    }

    return response()->view('frontend.pages.discovery_vendor', $data);
  }
}
