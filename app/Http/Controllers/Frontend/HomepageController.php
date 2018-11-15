<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\FunctionApp\CustomFunction;
use App\Database\Customers;
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
        'users' => $customer,
        'session' => Cookie::get()
      ];
    }
    else
    {
      $data = [
        'request' => $request->all(),
        'hasLogin' => false,
        'users' => null,
        'session' => Cookie::get()
      ];
    }
    return response()->view('frontend.pages.homepage', $data);
  }
}
