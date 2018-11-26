<?php

namespace App\Http\Controllers\Frontend\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use App\FunctionApp\CustomFunction;
use App\Database\Vendors;
use App\Database\Provinsi;
use App\Database\Kabupaten;
use App\Database\Kecamatan;
use App\Http\Controllers\Controller;

class AccountVendor extends Controller
{
  use CustomFunction;
  public function index( Request $request )
  {
    if( Cookie::get('hasLoginVendor') )
    {
      $datavendor = $this->getvendors( new Vendors, Cookie::get('vendor_id') );
      return response()->view('frontend.pages.vendors.account', [
        'request' => $request,
        'sessiondata' => Cookie::get(),
        'users' => $datavendor
      ]);
    }
    else
    {
      return response()->view('frontend.pages.vendors.login', [
        'request' => $request
      ]);
    }
  }

  public function settingpage( Request $request )
  {
    if( Cookie::get('hasLoginVendor') )
    {
      $datavendor = $this->getvendors( new Vendors, Cookie::get('vendor_id') );
      return response()->view('frontend.pages.vendors.editaccount', [
        'request' => $request,
        'sessiondata' => Cookie::get(),
        'users' => $datavendor
      ]);
    }
    else
    {
      return response()->view('frontend.pages.vendors.login', [
        'request' => $request
      ]);
    }
  }
}
