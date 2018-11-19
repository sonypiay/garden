<?php

namespace App\Http\Controllers\Frontend\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use App\FunctionApp\CustomFunction;
use App\Database\Vendors;
use App\Http\Controllers\Controller;

class LoginRegisterController extends Controller
{
  public function registerpage( Request $request )
  {
    if( Cookie::get('hasLoginVendor') )
    {

    }
    else
    {
      return response()->view('frontend.pages.vendors.register', [
        'getcookie' => $request->cookie(),
        'getsession' => $request->session()
      ]);
    }
  }
}
