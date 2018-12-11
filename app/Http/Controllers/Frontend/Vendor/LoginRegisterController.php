<?php

namespace App\Http\Controllers\Frontend\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use App\FunctionApp\CustomFunction;
use App\Database\Vendors;
use App\Database\Customers;
use App\Database\Provinsi;
use App\Database\Kabupaten;
use App\Database\Kecamatan;
use App\Http\Controllers\Controller;

class LoginRegisterController extends Controller
{
  use CustomFunction;

  public function registerpage( Request $request )
  {
    if( Cookie::get('hasLoginVendor') )
    {
      return redirect()->route('accountvendor_page');
    }
    else
    {
      return response()->view('frontend.pages.vendors.register', [
        'request' => $request,
        'getcookie' => $request->cookie(),
        'getsession' => $request->session()
      ]);
    }
  }

  public function loginpage( Request $request )
  {
    if( Cookie::get('hasLoginVendor') )
    {
      return redirect()->route('accountvendor_page');
    }
    else
    {
      return response()->view('frontend.pages.vendors.login', [
        'request' => $request,
        'getcookie' => $request->cookie(),
        'getsession' => $request->session()
      ]);
    }
  }

  public function dologin( Request $request, Vendors $vendors )
  {
    $email = $request->email;
    $password = $request->password;
    $vendors = $vendors->where('vendor_email_business', $email);
    if( $vendors->count() === 1 )
    {
      $getvendor = $vendors->first();
      if( Hash::check( $password, $getvendor->vendor_password ) )
      {
        $expired = time() + 60 * 60 * 24 * 30;
        $sessiondata = [
          'vendor_ip' => $request->server('REMOTE_ADDR'),
          'vendor_agent' => $request->server('HTTP_USER_AGENT'),
          'vendor_logintime' => date('Y-m-d H:i:s')
        ];

        Cookie::queue( Cookie::make('hasLoginVendor', true, $expired, '/') );
        Cookie::queue( Cookie::make('vendor_id', $getvendor->vendor_id, $expired, '/') );
        Cookie::queue( Cookie::make('session_vendor', base64_encode( json_encode( $sessiondata ) ), $expired, '/') );

        $res = [
          'status' => 200,
          'statusText' => 'success'
        ];
      }
      else
      {
        $res = [
          'status' => 401,
          'statusText' => 'Kata sandi salah'
        ];
      }
    }
    else
    {
      $res = [
        'status' => 401,
        'statusText' => 'Email tidak terdaftar'
      ];
    }
    return response()->json( $res, $res['status'] );
  }

  public function doregister( Request $request, Vendors $vendors, Customers $customers )
  {
    $vendor_name = $request->vendor_name;
    $phonenumber = $this->replaceNumber( $request->phonenumber );
    $phonenumber_business = $this->replaceNumber( $request->phonenumber_business );
    $region = $request->region;
    $district = $request->district;
    $subdistrict = $request->subdistrict;
    $address = $request->address;
    $zipcode = $request->zipcode;
    $vendor_ownername = $request->vendor_ownername;
    $vendor_email = $request->vendor_email;
    $password = $request->password;
    $slugname = $this->seoPatternSlice( $vendor_name );
    $checkemail_fromcustomer = $customers->where('customer_email', '=', $vendor_email)->count();
    $checkphone_fromcustomer = $customers->where('customer_mobile_phone', '=', $phonenumber)->count();
    $checkphone_business_fromcustomer = $customers->where('customer_mobile_phone', '=', $phonenumber_business)->count();

    $checkemail_fromvendor = $vendors->where('vendor_email_business', '=', $vendor_email)->count();
    $checkphone_fromvendor = $vendors->where('vendor_mobile_private', '=', $phonenumber)->count();
    $checkphone_business = $vendors->where('vendor_mobile_business', '=', $phonenumber_business)->count();

    if( $checkemail_fromcustomer == 1 )
    {
      $res = [
        'status' => 409,
        'statusText' => 'Email sudah terdaftar sebelumnya'
      ];
    }
    else if( $checkphone_fromcustomer == 1 )
    {
      $res = [
        'status' => 409,
        'statusText' => 'Nomor telepon sudah terdaftar sebelumnya'
      ];
    }
    else if( $checkphone_business_fromcustomer == 1 )
    {
      $res = [
        'status' => 409,
        'statusText' => 'Nomor telepon sudah terdaftar sebelumnya'
      ];
    }
    else if( $checkemail_fromvendor == 1 )
    {
      $res = [
        'status' => 409,
        'statusText' => 'Email sudah terdaftar sebelumnya'
      ];
    }
    else if( $checkphone_business == 1 )
    {
      $res = [
        'status' => 409,
        'statusText' => 'Nomor telepon sudah terdaftar sebelumnya'
      ];
    }
    else
    {
      $date = date('Y-m-d H:i:s');
      $vendors = new $vendors;
      $vendors->vendor_name = $vendor_name;
      $vendors->vendor_mobile_private = $phonenumber;
      $vendors->vendor_mobile_business = $phonenumber_business;
      $vendors->vendor_region = $region;
      $vendors->vendor_district = $district;
      $vendors->vendor_subdistrict = $subdistrict;
      $vendors->vendor_address = $address;
      $vendors->vendor_zipcode = $zipcode;
      $vendors->vendor_ownername = $vendor_ownername;
      $vendors->vendor_email_business = $vendor_email;
      $vendors->vendor_password = Hash::make( $password );
      $vendors->vendor_registered = $date;
      $vendors->vendor_slug_name = $slugname;
      $vendors->save();

      $result = $vendors->select('vendor_id')->where('vendor_email_business', $vendor_email)->first();
      $expired = time() + 60 * 60 * 24 * 30;
      $sessiondata = [
        'vendor_ip' => $request->server('REMOTE_ADDR'),
        'vendor_agent' => $request->server('HTTP_USER_AGENT'),
        'vendor_logintime' => date('Y-m-d H:i:s')
      ];

      Cookie::queue( Cookie::make('hasLoginVendor', true, $expired, '/') );
      Cookie::queue( Cookie::make('vendor_id', $result->vendor_id, $expired, '/') );
      Cookie::queue( Cookie::make('session_vendor', base64_encode( json_encode( $sessiondata ) ), $expired, '/') );

      $res = [
        'status' => 200,
        'statusText' => 'success'
      ];
    }
    return response()->json( $res, $res['status'] );
  }

  public function logout( Cookie $cookie )
  {
    if( $cookie::get('hasLoginVendor') )
    {
      $cookie::queue( $cookie::forget('hasLoginVendor') );
      $cookie::queue( $cookie::forget('vendor_id') );
      $cookie::queue( $cookie::forget('session_vendor') );
      session()->flush();

      return redirect()->route('loginpage_vendor');
    }
    else
    {
      return redirect()->route('loginpage_vendor');
    }
  }

  public function lupapassword( Request $request, Customers $customers )
  {
    if( Cookie::get('hasLoginCustomers') || Cookie::get('hasLoginVendor') )
    {
      return redirect()->route('homepage');
    }
    else
    {
      return response()->view('frontend.pages.vendor.lupapassword', [
        'request' => $request
      ]);
    }
  }

  public function checkemail( Request $request, Vendors $vendors )
  {
    $email = $request->email;
    $checkemail = $vendors->where('vendor_email', $email)->count();
    if( $checkemail === 1 )
    {
      $request->session()->put('changepassword_vendor', true);
      $request->session()->put('session_email_vendor', $email);
      $res = [
        'status' => 200,
        'statusText' => 'Email ditemukan'
      ];
    }
    else
    {
      $res = [
        'status' => 401,
        'statusText' => 'Email tidak terdaftar'
      ];
    }

    return response()->json( $res, $res['status'] );
  }

  public function change_password( Request $request )
  {
    if( Cookie::get('hasLoginCustomers') || Cookie::get('hasLoginVendor') )
    {
      return redirect()->route('homepage');
    }
    else
    {
      if( $request->session('changepassword_vendor') )
      {
        return response()->view('frontend.pages.vendor.reset_password', [
          'request' => $request
        ]);
      }
      else
      {
        return redirect()->route('homepage');
      }
    }
  }

  public function reset_password( Request $request, Vendors $vendors )
  {
    $password = $request->password;
    $email = $request->session()->get('session_email_vendor');
    $vendors = $vendors->where('vendor_email', $email)->first();
    $vendors->vendor_password = Hash::make( $password, ['round' => 16] );
    $vendors->save();

    $res = [
      'status' => 200,
      'statusText' => 'success'
    ];
    return response()->json( $res, $res['status'] );
  }
}
