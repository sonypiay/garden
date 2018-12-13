<?php

namespace App\Http\Controllers\Frontend\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\FunctionApp\CustomFunction;
use App\Database\Vendors;
use App\Database\Customers;
use App\Database\Messages;
use App\Database\MessagesConversation;
use App\Http\Controllers\Controller;

class MessagesVendor extends Controller
{
  use CustomFunction;

  public function index( Request $request )
  {
    if( Cookie::get('hasLoginVendor') )
    {
      $datavendor = $this->getvendors( new Vendors, Cookie::get('vendor_id') );
      return response()->view('frontend.pages.vendors.messages', [
        'request' => $request,
        'sessiondata' => Cookie::get(),
        'myaccount' => $datavendor
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
