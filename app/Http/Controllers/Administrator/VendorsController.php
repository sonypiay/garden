<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\FunctionApp\CustomFunction;
use App\Database\Vendors;
use App\Database\Kabupaten;
use App\Http\Controllers\Controller;

class VendorsController extends Controller
{
  public function index( Request $request, Kabupaten $kabupaten )
  {
    if( Cookie::get('hasLoginPanel') )
    {
      return response()->view('administrator.pages.vendors', [
        'request' => $request,
        'getSession' => $request->session(),
        'getCookies' => $request->cookie(),
        'kabupaten' => $kabupaten->orderBy('nama_kab', 'asc')->get()
      ]);
    }
    else
    {
      return redirect( route('loginadminpage') );
    }
  }

  public function list( Request $request, Vendors $vendors )
  {
    $rows = $request->rows;
    $keywords = $request->keywords;
    $kabupaten = $request->kabupaten;
    $query = $vendors->join('kabupaten', 'vendors.vendor_district', '=', 'kabupaten.id_kab');
    if( empty( $keywords ) )
    {
      if( $kabupaten === 'all' )
      {
        $query = $query;
      }
      else
      {
        $query = $query->where('vendors.vendor_district', '=', $kabupaten);
      }
    }
    else
    {
      if( $kabupaten === 'all' )
      {
        $query = $query->where('vendors.vendor_name', 'like', '%' . $keywords . '%')
        ->orWhere('vendors.vendor_ownername', 'like', '%' . $keywords . '%')
        ->orWhere('vendors.vendor_email_business', 'like', '%' . $keywords . '%');
      }
      else
      {
        $query = $query->where([
          ['vendors.vendor_district', '=', $kabupaten],
          ['vendors.vendor_name', 'like', '%' . $keywords . '%']
        ])
        ->orWhere([
          ['vendors.vendor_district', '=', $kabupaten],
          ['vendors.vendor_ownername', 'like', '%' . $keywords . '%']
        ])
        ->orWhere([
          ['vendors.vendor_district', '=', $kabupaten],
          ['vendors.vendor_email_business', 'like', '%' . $keywords . '%']
        ]);
      }
    }

    $results = $query->orderBy('vendors.vendor_id', 'desc')->paginate( $rows );
    return response()->json( $results );
  }
}
