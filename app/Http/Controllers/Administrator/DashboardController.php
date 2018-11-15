<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class DashboardController extends Controller
{
  public function index( Request $request )
  {
    if( Cookie::get('hasLoginPanel') )
    {
      return response()->view('administrator.pages.dashboard', [
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
}
