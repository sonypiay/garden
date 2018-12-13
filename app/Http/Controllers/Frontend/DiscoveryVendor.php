<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\FunctionApp\CustomFunction;
use App\Database\Provinsi;
use App\Database\Kabupaten;
use App\Database\Vendors;
use App\Database\VendorPortfolio;
use App\Database\VendorPortfolioImages;
use App\Database\Customers;
use App\Database\BookingTransaction;
use App\Http\Controllers\Controller;

class DiscoveryVendor extends Controller
{
  use CustomFunction;

  public function index( Request $request, Vendors $vendors, Customers $customers )
  {
    if( Cookie::get('hasLoginCustomers') )
    {
      $customer = $this->getcustomer( $customers, Cookie::get('customer_id') );
      $data = [
        'request' => $request,
        'hasLogin' => true,
        'myaccount' => $customer,
        'sessiondata' => Cookie::get()
      ];
    }
    else if( Cookie::get('hasLoginVendor') )
    {
      $vendors = $this->getvendors( $vendors, Cookie::get('vendor_id') );
      $data = [
        'request' => $request,
        'hasLogin' => true,
        'myaccount' => $vendors,
        'sessiondata' => Cookie::get()
      ];
    }
    else
    {
      $data = [
        'request' => $request,
        'hasLogin' => false,
        'myaccount' => null,
        'sessiondata' => Cookie::get()
      ];
    }

    return response()->view('frontend.pages.discovery_vendor', $data);
  }

  public function discovervendor( Request $request, Vendors $vendors )
  {
    $keywords = $request->keywords;
    $city = $request->city;
    $rows = 12;
    if( empty( $keywords ) )
    {
      if( $city == 'allcity' )
      {
        $query = $vendors->join('kabupaten','vendors.vendor_district', '=', 'kabupaten.id_kab')
        ->orderBy('vendors.vendor_name', 'asc');
      }
      else
      {
        $query = $vendors->join('kabupaten','vendors.vendor_district', '=', 'kabupaten.id_kab')
        ->where('kabupaten.kode_kab', $city)
        ->orderBy('vendors.vendor_name', 'asc');
      }
    }
    else
    {
      if( $city == 'allcity' )
      {
        $query = $vendors->join('kabupaten','vendors.vendor_district', '=', 'kabupaten.id_kab')
        ->where('vendors.vendor_name', 'like', '%' . $keywords . '%')
        ->orderBy('vendors.vendor_name', 'asc');
      }
      else
      {
        $query = $vendors->join('kabupaten','vendors.vendor_district', '=', 'kabupaten.id_kab')
        ->where([
          ['vendors.vendor_name', 'like', '%' . $keywords . '%'],
          ['kabupaten.kode_kab', $city]
        ])
        ->orderBy('vendors.vendor_name', 'asc');
      }
    }

    $fetch = $query->paginate( $rows );
    return response()->json( $fetch );
  }

  public function selectvendor( Request $request, Vendors $vendors, Customers $customers, $id )
  {
    $query = $vendors->join('kabupaten','vendors.vendor_district', '=', 'kabupaten.id_kab')
    ->where('vendors.vendor_slug_name', $id)->first();

    if( Cookie::get('hasLoginCustomers') )
    {
      $customer = $this->getcustomer( $customers, Cookie::get('customer_id') );
      $data = [
        'request' => $request,
        'hasLogin' => true,
        'myaccount' => $customer,
        'sessiondata' => Cookie::get(),
        'vendor' => $query
      ];
    }
    else if( Cookie::get('hasLoginVendor') )
    {
      $vendors = $this->getvendors( $vendors, Cookie::get('vendor_id') );
      $data = [
        'request' => $request,
        'hasLogin' => true,
        'myaccount' => $vendors,
        'sessiondata' => Cookie::get(),
        'vendor' => $query
      ];
    }
    else
    {
      $data = [
        'request' => $request,
        'hasLogin' => false,
        'myaccount' => null,
        'sessiondata' => Cookie::get(),
        'vendor' => $query
      ];
    }
    return response()->view('frontend.pages.detail_vendor', $data);
  }

  public function portfolio_vendor( Request $request, VendorPortfolio $portfolio, $id )
  {
    $rows = $request->rows;
    $getportfolio = $portfolio->select(
      'vendors.vendor_id',
      'vendors.vendor_slug_name',
      'vendor_portfolio.portfolio_id',
      'vendor_portfolio.portfolio_name',
      'vendor_portfolio.portfolio_slug_name',
      'vendor_portfolio.portfolio_thumbnail',
      'vendor_portfolio.created_at'
    )
    ->join('vendors', 'vendor_portfolio.vendor_id', '=', 'vendors.vendor_id')
    ->where('vendors.vendor_slug_name', '=', $id)
    ->orderBy('vendor_portfolio.portfolio_id')
    ->paginate( $rows );
    return response()->json( $getportfolio );
  }

  public function view_portfolio_image( VendorPortfolioImages $images, $id )
  {
    $images = $images->where('portfolio_id', $id);
    $data = [
      'total' => $images->count(),
      'results' => $images->get()
    ];
    return response()->json( $data, 200 );
  }
}
