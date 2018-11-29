<?php

namespace App\Http\Controllers\Frontend\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
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

  public function datavendor( Vendors $vendor )
  {
    $datavendor = $vendor->where('vendor_id', Cookie::get('vendor_id'))->first();
    return response()->json( $datavendor );
  }

  public function saveaccount( Request $request, Vendors $vendors )
  {
    $vendor_name = $request->vendor_name;
    $ownername = $request->ownername;
    $region = $request->region;
    $district = $request->district;
    $subdistrict = $request->subdistrict;
    $address = $request->address;
    $kodepos = $request->kodepos;

    $vendor = $vendors->where('vendor_id', Cookie::get('vendor_id'))->first();
    $vendor->vendor_name = $vendor_name;
    $vendor->vendor_ownername = $ownername;
    $vendor->vendor_region = $region;
    $vendor->vendor_district = $district;
    $vendor->vendor_subdistrict = $subdistrict;
    $vendor->vendor_address = $address;
    $vendor->vendor_zipcode = $kodepos;
    $vendor->vendor_slug_name = $this->seoPatternSlice( $vendor_name );
    $vendor->save();
    $res = [
      'status' => 200,
      'statusText' => 'Perubahan berhasil disimpan'
    ];
    return response()->json( $res, $res['status'] );
  }

  public function change_password( Request $request )
  {
    if( Cookie::get('hasLoginVendor') )
    {
      $datavendor = $this->getvendors( new Vendors, Cookie::get('vendor_id') );
      return response()->view('frontend.pages.vendors.changepassword', [
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

  public function savepassword( Request $request, Vendors $vendors )
  {
    $password = $request->password;
    $vendor = $vendors->where('vendor_id', Cookie::get('vendor_id'))->first();
    $vendor->vendor_password = Hash::make( $password );
    $vendor->save();
    $res = [
      'status' => 200,
      'statusText' => 'Kata sandi berhasil diubah.'
    ];
    return response()->json( $res, $res['status'] );
  }

  public function edit_email( Request $request )
  {
    if( Cookie::get('hasLoginVendor') )
    {
      $datavendor = $this->getvendors( new Vendors, Cookie::get('vendor_id') );
      return response()->view('frontend.pages.vendors.editemail', [
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

  public function saveemail( Request $request, Vendors $vendors )
  {
    $email = $request->email;
    $getvendor = $vendors->where('vendor_id', Cookie::get('vendor_id'))->first();

    if( $getvendor->vendor_email_business != $email )
    {
      $checkemail = $vendors->where('vendor_email_business', $email)->count();
      if( $checkemail === 1 )
      {
        $res = [
          'status' => 409,
          'statusText' => 'Email sudah terdaftar'
        ];
      }
      else
      {
        $getvendor->vendor_email_business = $email;
        $getvendor->vendor_verified = 'N';
        $getvendor->save();

        $res = [
          'status' => 200,
          'statusText' => 'Email berhasil diubah.'
        ];
      }
    }
    else
    {
      $getvendor->vendor_email_business = $email;
      $getvendor->save();

      $res = [
        'status' => 200,
        'statusText' => 'Email berhasil diubah.'
      ];
    }
    return response()->json( $res, $res['status'] );
  }

  public function edit_notelepon( Request $request )
  {
    if( Cookie::get('hasLoginVendor') )
    {
      $datavendor = $this->getvendors( new Vendors, Cookie::get('vendor_id') );
      return response()->view('frontend.pages.vendors.edittelepon', [
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

  public function save_notelepon( Request $request, Vendors $vendors )
  {
    $mobile_private = $request->mobile_private;
    $mobile_business = $request->mobile_business;
  }
}
