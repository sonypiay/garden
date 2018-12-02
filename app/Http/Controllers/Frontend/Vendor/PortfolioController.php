<?php

namespace App\Http\Controllers\Frontend\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\FunctionApp\CustomFunction;
use App\Database\Vendors;
use App\Database\VendorPortfolio;
use App\Database\VendorPortfolioImages;
use App\Http\Controllers\Controller;

class PortfolioController extends Controller
{
  use CustomFunction;

  public function index( Request $request )
  {
    if( Cookie::get('hasLoginVendor') )
    {
      $datavendor = $this->getvendors( new Vendors, Cookie::get('vendor_id') );
      return response()->view('frontend.pages.vendors.portfolio', [
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

  public function listportfolio( Request $request, VendorPortfolio $portfolio )
  {
    $keywords = $request->keywords;
    $rows = $request->rows;
    if( empty( $keywords ) )
    {
      $query = $portfolio->orderBy('portfolio_id', 'desc')->paginate( $rows );
    }
    else
    {
      $query = $portfolio->where('portfolio_name', 'like', '%' . $keywords . '%')
      ->orderBy('portfolio_id', 'desc')->paginate( $rows );
    }

    return response()->json( $query );
  }

  public function store_portfolio( Request $request, VendorPortfolio $portfolio )
  {
    $namaportfolio = $request->namaportfolio;
    $portfolio = new $portfolio;
    $portfolio->vendor_id = Cookie::get('vendor_id');
    $portfolio->portfolio_name = $namaportfolio;
    $portfolio->portfolio_slug_name = $this->seoPatternSlice( $namaportfolio );
    $portfolio->save();
    $res = [
      'status' => 200,
      'statusText' => 'Portfolio berhasil ditambahkan.'
    ];
    return response()->json( $res, $res['status'] );
  }

  public function save_portfolio( Request $request, VendorPortfolio $portfolio, $id )
  {
    $namaportfolio = $request->namaportfolio;
    $portfolio = $portfolio->where('portfolio_id', $id)->first();
    $portfolio->portfolio_name = $namaportfolio;
    $portfolio->portfolio_slug_name = $this->seoPatternSlice( $namaportfolio );
    $portfolio->save();
    $res = [
      'status' => 200,
      'statusText' => 'Perubahan berhasil disimpan.'
    ];
    return response()->json( $res, $res['status'] );
  }
}
