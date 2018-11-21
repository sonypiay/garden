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
    }
    else
    {
      return response()->view('frontend.pages.vendors.register', [
        'getcookie' => $request->cookie(),
        'getsession' => $request->session()
      ]);
    }
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

    /*$data = [
      'email_customer' => $checkemail_fromcustomer,
      'email_vendor' => $checkemail_fromvendor,
      'phone_customer' => $checkphone_fromcustomer,
      'phone_business_customer' => $checkphone_business_fromcustomer,
      'phone_vendor' => $checkphone_fromvendor,
      'phone_business' => $checkphone_business
    ];*/
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
      $res = [
        'status' => 200,
        'statusText' => 'success'
      ];
    }
    return response()->json( $res, $res['status'] );
  }
}
