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

  public function delete_portfolio( Request $request, VendorPortfolio $portfolio, VendorPortfolioImages $portfolio_image, $id )
  {
    $fetch = $portfolio->where('portfolio_id', $id);
    $getimage = $portfolio_image->where('portfolio_id', $id);
    $storage = Storage::disk('imagestorage');
    if( $getimage->count() != 0 )
    {
      foreach( $getimage->get() as $image )
      {
        if( $storage->exists('vendor/portfolios/' . $image->images_name) )
        {
          $storage->delete('vendor/portfolios/' . $image->images_name);
        }
      }
    }

    $fetch->delete();
    $getimage->delete();
    $res = [
      'status' => 200,
      'statusText' => 'Portfolio berhasil dihapus'
    ];
    return response()->json( $res, $res['status'] );
  }

  public function detail_portfolio( Request $request, VendorPortfolio $portfolio, $id )
  {
    if( Cookie::get('hasLoginVendor') )
    {
      $datavendor = $this->getvendors( new Vendors, Cookie::get('vendor_id') );
      $result = $portfolio->where('portfolio_slug_name', $id)->first();
      return response()->view('frontend.pages.vendors.portfolioimage', [
        'request' => $request,
        'sessiondata' => Cookie::get(),
        'myaccount' => $datavendor,
        'portfolio' => $result
      ]);
    }
    else
    {
      return response()->view('frontend.pages.vendors.login', [
        'request' => $request
      ]);
    }
  }

  public function portfolio_image( Request $request, VendorPortfolio $portfolio, VendorPortfolioImages $images, $id )
  {
    $rows = $request->rows;
    $result = $portfolio->select('portfolio_id')->where('portfolio_slug_name', $id)->first();
    $query = $images->where('portfolio_id', $result->portfolio_id)
    ->orderBy('images_id', 'desc')
    ->paginate( $rows );

    return response()->json( $query );
  }

  public function store_portfolio_image( Request $request, VendorPortfolioImages $images, VendorPortfolio $portfolio )
  {
    $portfolio_id = $request->portfolio_id;
    $thumbnail = $request->thumbnail;
    $filename = $request->file('filename');
    $getfilename = hash('crc32b', bin2hex( base64_encode( time() ) ) . $filename->getClientOriginalName());
    $getextension = $filename->getClientOriginalExtension();
    $getsize = $filename->getClientSize();
    $storage = Storage::disk('imagestorage');
    $origfilename = $getfilename . '.' . $getextension;
    if( $getsize > 2048000 )
    {
      $res = [
        'status' => 413,
        'statusText' => 'Ukuran gambar terlalu besar. Makmsimal 1MB'
      ];
    }
    else
    {
      $storage->putFileAs('vendor/portfolios', $filename, $origfilename);
      $insert = new $images;
      $getimagethumbnail = $images->where([
          ['portfolio_id', $portfolio_id],
          ['thumbnail', 'Y']
      ])->count();
      if( $getimagethumbnail !== 0 )
      {
        $setthumbnail = $images->where('portfolio_id', $portfolio_id)->update(['thumbnail' => 'N']);
      }

      $portfolio = $portfolio->where('portfolio_id', $portfolio_id)->first();
      $insert->images_name = $origfilename;
      $insert->portfolio_id = $portfolio_id;
      if( ! empty( $thumbnail ) )
      {
        $insert->thumbnail = 'Y';
        $portfolio->portfolio_thumbnail = $origfilename;
      }
      $insert->save();
      $portfolio->save();

      $res = [
        'status' => 200,
        'statusText' => 'Gambar berhasil diupload.'
      ];
    }
    return response()->json( $res, $res['status'] );
  }

  public function save_portfolio_image( Request $request, VendorPortfolioImages $images, VendorPortfolio $portfolio, $id )
  {
    $portfolio_id = $request->portfolio_id;
    $thumbnail = $request->thumbnail;
    $filename = $request->filename;
    $storage = Storage::disk('imagestorage');
    $getimage = $images->where('images_id', $id)->first();
    $getportfolio = $portfolio->where('portfolio_id', $getimage->portfolio_id)->first();
    $getimagethumbnail = $images->where([
        ['portfolio_id', $getimage->portfolio_id],
        ['thumbnail', 'Y']
    ]);
    if( $getimagethumbnail !== 0 )
    {
      $images->where('portfolio_id', $getimage->portfolio_id)->update(['thumbnail' => 'N']);
    }

    if( ! empty( $filename ) )
    {
      $getfilename = hash('crc32b', bin2hex( base64_encode( time() ) ) . $filename->getClientOriginalName());
      $getextension = $filename->getClientOriginalExtension();
      $getsize = $filename->getClientSize();
      $origfilename = $getfilename . '.' . $getextension;
      if( $getsize > 2048000 )
      {
        $res = [
          'status' => 413,
          'statusText' => 'Ukuran gambar terlalu besar. Makmsimal 1MB'
        ];
      }
      else
      {
        if( $storage->exists( 'vendors/portfolios/' . $getimage->images_name ) )
        {
          $storage->delete('vendors/portfolios/' . $getimage->images_name);
        }
        $storage->putFileAs('vendor/portfolios', $filename, $origfilename);

        $getimage->images_name = $origfilename;
        if( $thumbnail === 'true' )
        {
          $getimage->thumbnail = 'Y';
          $getportfolio->portfolio_thumbnail = $origfilename;
        }
        else
        {
          $getimage->thumbnail = 'N';
          if( $getimagethumbnail->count() !== 0 )
          {
            $getportfolio->portfolio_thumbnail = $getimagethumbnail->images_name;
          }
          else
          {
            $getportfolio->portfolio_thumbnail = '';
          }
        }
        $getimage->save();
        $getportfolio->save();
        $res = [
          'status' => 200,
          'statusText' => 'Perubahan berhasil disimpan.'
        ];
      }
    }
    else
    {
      if( $thumbnail === 'true' )
      {
        $getimage->thumbnail = 'Y';
        $getportfolio->portfolio_thumbnail = $getimage->images_name;
      }
      else
      {
        $getimage->thumbnail = 'N';
        if( $getimagethumbnail->count() !== 0 )
        {
          $getportfolio->portfolio_thumbnail = $getimagethumbnail->images_name;
        }
        else
        {
          $getportfolio->portfolio_thumbnail = '';
        }
      }

      $getimage->save();
      $getportfolio->save();
      $res = [
        'status' => 200,
        'statusText' => 'Perubahan berhasil disimpan.'
      ];
    }

    return response()->json( $res, $res['status'] );
  }
}
