<?php

namespace App\Http\Controllers\Frontend\Customers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\FunctionApp\CustomFunction;
use App\Database\Customers;
use App\Database\CustomersActivityLog;
use App\Http\Controllers\Controller;

class LoginRegisterController extends Controller
{
  use CustomFunction;

  public function login( Request $request )
  {
    if( Cookie::get('hasLoginCustomers') )
    {
      return redirect()->route('accountcustomer_page');
    }
    else
    {
      return response()->view('frontend.pages.customers.login', [
        'request' => $request,
        'getcookie' => $request->cookie(),
        'getsession' => $request->session()
      ]);
    }
  }

  public function register( Request $request, Customers $customers )
  {
    if( Cookie::get('hasLoginCustomers') )
    {
      return redirect()->route('accountcustomer_page');
    }
    else
    {
      return response()->view('frontend.pages.customers.register', [
        'request' => $request,
        'getcookie' => $request->cookie(),
        'getsession' => $request->session()
      ]);
    }
  }

  public function doRegister( Request $request, Customers $customers )
  {
    $fullname = $request->fullname;
    $email = $request->email;
    $notelepon = str_replace('+', '', preg_replace('/^0|^62/', '', $request->telepon));
    $password = $request->password;
    $customers = new $customers;
    $checkemail = $customers->where('customer_email', '=', $email)->count();
    $checktelepon = $customers->where('customer_mobile_phone', '=', $notelepon)->count();
    if( $checkemail === 1 )
    {
      $res = [
        'status' => 422,
        'statusText' => $email . ' sudah terdaftar'
      ];
    }
    else if( $checktelepon === 1 )
    {
      $res = [
        'status' => 422,
        'statusText' => $notelepon . ' sudah terdaftar'
      ];
    }
    else
    {
      $customers->customer_name = $fullname;
      $customers->customer_email = $email;
      $customers->customer_mobile_phone = $notelepon;
      $customers->customer_password = Hash::make( $password, ['round' => 16]);
      $customers->customer_registered = date('Y-m-d H:i:s');
      $customers->save();

      $result = $customers->select('customer_id')->where('customer_email', '=', $email)->first();
      $expired = time() + 60 * 60 * 24 * 30;
      $sessiondata = [
        'cust_ip' => $request->server('REMOTE_ADDR'),
        'cust_agent' => $request->server('HTTP_USER_AGENT'),
        'cust_logintime' => date('Y-m-d H:i:s')
      ];

      Cookie::queue( Cookie::make('hasLoginCustomers', true, $expired + time(), '/') );
      Cookie::queue( Cookie::make('customer_id', $result->customer_id, $expired + time(), '/') );
      Cookie::queue( Cookie::make('sesscustomer', base64_encode( json_encode( $sessiondata ) ), $expired + time(), '/') );
      session()->put('sesscustomer', $sessiondata);

      $customerlog = new CustomersActivityLog;
      $customerlog->log_type = 'register';
      $customerlog->log_description = $email . ' registrasi pada ' . date('Y-m-d H:i:s');
      $customerlog->log_datetime = date('Y-m-d H:i:s');
      $customerlog->log_ip = $request->server('REMOTE_ADDR');
      $customerlog->log_agent = $this->getOSAgent( $request->server('HTTP_USER_AGENT') );
      $customerlog->save();

      $res = [
        'status' => 200,
        'statusText' => 'Registrasi berhasil'
      ];
    }

    return response()->json( $res, $res['status'] );
  }

  public function doLogin( Request $request, Customers $customers, CustomersActivityLog $customerlog )
  {
    $email = $request->email;
    $password = $request->password;
    $customers = $customers->where('customer_email', $email);
    if( $customers->count() === 1 )
    {
      $getcustomer = $customers->first();
      if( Hash::check( $password, $getcustomer->customer_password ) )
      {
        $result = $customers->first();
        $expired = time() + 60 * 60 * 24 * 30;
        $sessiondata = [
          'cust_ip' => $request->server('REMOTE_ADDR'),
          'cust_agent' => $request->server('HTTP_USER_AGENT'),
          'cust_logintime' => date('Y-m-d H:i:s')
        ];

        Cookie::queue( Cookie::make('hasLoginCustomers', true, $expired, '/') );
        Cookie::queue( Cookie::make('customer_id', $result->customer_id, $expired, '/') );
        Cookie::queue( Cookie::make('sesscustomer', base64_encode( json_encode( $sessiondata ) ), $expired, '/') );
        session()->put('sesscustomer', $sessiondata);

        /*$customerlog = new CustomersActivityLog;
        $customerlog->log_type = 'register';
        $customerlog->log_description = $email . ' registrasi pada ' . date('Y-m-d H:i:s');
        $customerlog->log_datetime = date('Y-m-d H:i:s');
        $customerlog->log_ip = $request->server('REMOTE_ADDR');
        $customerlog->log_agent = $this->getOSAgent( $request->server('HTTP_USER_AGENT') );
        $customerlog->save();*/

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

  public function logout( Request $request, Cookie $cookie, Customers $customers, CustomersActivityLog $log )
  {
    if( $cookie::get('hasLoginCustomers') )
    {
      $cookiedata = $this->get_cookiescustomer();
      $sessiondata = $this->get_sessioncustomer();

      $cookie::queue( $cookie::forget('hasLoginCustomers') );
      $cookie::queue( $cookie::forget('customer_id') );
      $cookie::queue( $cookie::forget('sesscustomer') );
      session()->forget('sesscustomer');
      session()->flush();

      return redirect()->route('loginpage_customer');
    }
    else
    {
      return redirect()->route('loginpage_customer');
    }
  }
}
