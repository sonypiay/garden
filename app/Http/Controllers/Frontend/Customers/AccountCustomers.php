<?php

namespace App\Http\Controllers\Frontend\Customers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\FunctionApp\CustomFunction;
use App\Database\Customers;
use App\Http\Controllers\Controller;

class AccountCustomers extends Controller
{
  use CustomFunction;

  public function index( Request $request, Customers $customers )
  {
    if( Cookie::get('hasLoginCustomers') )
    {
      $datacustomer = $this->getcustomer( $customers, Cookie::get('customer_id') );
      return response()->view('frontend.pages.customers.account', [
        'sessiondata' => $this->get_sessioncustomer(),
        'myaccount' => $datacustomer
      ]);
    }
    else
    {
      return response()->view('frontend.pages.customers.login');
    }
  }

  public function editprofile( Request $request, Customers $customers )
  {
    if( Cookie::get('hasLoginCustomers') )
    {
      $datacustomer = $this->getcustomer( $customers, Cookie::get('customer_id') );
      return response()->view('frontend.pages.customers.editaccount', [
        'sessiondata' => $this->get_sessioncustomer(),
        'myaccount' => $datacustomer
      ]);
    }
    else
    {
      return response()->view('frontend.pages.customers.login');
    }
  }

  public function saveprofile( Request $request, Customers $customers )
  {
    $fullname = $request->fullname;
    $username = isset( $request->username ) ? $request->username : '';
    $birthday = $request->birthday;
    $gender = $request->gender;
    $getcustomers = $this->getcustomer( $customers, Cookie::get('customer_id') );
    if( $getcustomers->customer_username == $username )
    {
      $getcustomers->customer_name = $fullname;
      $getcustomers->customer_gender = $gender;
      $getcustomers->customer_birthday = $birthday;
      $getcustomers->save();

      $res = [
        'status' => 200,
        'statusText' => 'Profil berhasil diperbarui.'
      ];
    }
    else
    {
      $customers = $customers->where('customer_username', $username)->count();
      if( $customers === 1 )
      {
        $res = [
          'status' => 422,
          'statusText' => 'Username sudah terdaftar'
        ];
      }
      else
      {
        $getcustomers->customer_name = $fullname;
        $getcustomers->customer_gender = $gender;
        $getcustomers->customer_birthday = $birthday;
        $getcustomers->customer_username = $username;
        $getcustomers->save();
        $res = [
          'status' => 200,
          'statusText' => 'Profil berhasil diperbarui.'
        ];
      }
    }
    return response()->json( $res, $res['status'] );
  }
}
