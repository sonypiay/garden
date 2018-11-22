<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\FunctionApp\CustomFunction;
use App\Database\Customers;
use App\Database\Vendors;
use App\Database\Kabupaten;
use App\Http\Controllers\Controller;

class HomepageController extends Controller
{
  use CustomFunction;

  public function index( Request $request, Cookie $cookie )
  {
    if( Cookie::get('hasLoginCustomers') )
    {
      $customer = $this->getcustomer( new Customers, Cookie::get('customer_id') );
      $data = [
        'request' => $request->all(),
        'hasLogin' => true,
        'users' => $customer
      ];
    }
    else if( Cookie::get('hasLoginVendor') )
    {
      $vendors = $this->getvendors( new Vendors, Cookie::get('vendor_id') );
      $data = [
        'request' => $request->all(),
        'hasLogin' => true,
        'users' => $vendors
      ];
    }
    else
    {
      $data = [
        'request' => $request->all(),
        'hasLogin' => false,
        'users' => null
      ];
    }
    $kabupaten = new Kabupaten;
    $data['kabupaten'] = $kabupaten->orderBy('nama_kab', 'asc')->get();
    return response()->view('frontend.pages.homepage', $data);
  }
}
