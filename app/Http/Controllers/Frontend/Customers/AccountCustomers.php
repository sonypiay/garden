<?php

namespace App\Http\Controllers\Frontend\Customers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\FunctionApp\CustomFunction;
use App\Database\Customers;
use App\Database\CustomersBankAccount;
use App\Database\BankCustomer;
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

  public function change_password( Request $request, Customers $customers )
  {
    if( Cookie::get('hasLoginCustomers') )
    {
      $datacustomer = $this->getcustomer( $customers, Cookie::get('customer_id') );
      return response()->view('frontend.pages.customers.changepassword', [
        'sessiondata' => $this->get_sessioncustomer(),
        'myaccount' => $datacustomer
      ]);
    }
    else
    {
      return response()->view('frontend.pages.customers.login');
    }
  }

  public function savepassword( Request $request, Customers $customers )
  {
    $password = $request->password;
    $getcustomer = $this->getcustomer( $customers, Cookie::get('customer_id') );
    $getcustomer->customer_password = Hash::make( $password, ['round' => 16]);
    $getcustomer->save();

    $res = [
      'status' => 200,
      'statusText' => 'Sandi berhasil diubah.'
    ];

    return response()->json( $res, $res['status'] );
  }

  public function editemail( Request $request, Customers $customers )
  {
    if( Cookie::get('hasLoginCustomers') )
    {
      $datacustomer = $this->getcustomer( $customers, Cookie::get('customer_id') );
      return response()->view('frontend.pages.customers.editemail', [
        'sessiondata' => $this->get_sessioncustomer(),
        'myaccount' => $datacustomer
      ]);
    }
    else
    {
      return response()->view('frontend.pages.customers.login');
    }
  }

  public function saveemail( Request $request, Customers $customers )
  {
    $email = $request->email;
    $getcustomer = $this->getcustomer( $customers, Cookie::get('customer_id') );

    if( $getcustomer->customer_email != $email )
    {
      $checkemail = $customers->where('customer_email', $email)->count();
      if( $checkemail === 1 )
      {
        $res = [
          'status' => 422,
          'statusText' => 'Email sudah terdaftar'
        ];
      }
      else
      {
        $getcustomer->customer_email = $email;
        $getcustomer->customer_verified = 'N';
        $getcustomer->save();

        $res = [
          'status' => 200,
          'statusText' => 'Email berhasil diubah.'
        ];
      }
    }
    else
    {
      $getcustomer->customer_email = $email;
      $getcustomer->save();

      $res = [
        'status' => 200,
        'statusText' => 'Email berhasil diubah.'
      ];
    }

    return response()->json( $res, $res['status'] );
  }

  public function editnotelepon( Request $request, Customers $customers )
  {
    if( Cookie::get('hasLoginCustomers') )
    {
      $datacustomer = $this->getcustomer( $customers, Cookie::get('customer_id') );
      return response()->view('frontend.pages.customers.edittelepon', [
        'sessiondata' => $this->get_sessioncustomer(),
        'myaccount' => $datacustomer
      ]);
    }
    else
    {
      return response()->view('frontend.pages.customers.login');
    }
  }

  public function savephone( Request $request, Customers $customers )
  {
    $notelepon = str_replace('+', '', preg_replace('/^0|^62/', '', $request->notelepon));
    $getcustomer = $this->getcustomer( $customers, Cookie::get('customer_id') );

    if( $getcustomer->customer_mobile_phone != $notelepon )
    {
      $checktelepon = $customers->where('customer_mobile_phone', $notelepon)->count();
      if( $checktelepon === 1 )
      {
        $res = [
          'status' => 422,
          'statusText' => 'Nomor telepon sudah terdaftar'
        ];
      }
      else
      {
        $getcustomer->customer_mobile_phone = $notelepon;
        $getcustomer->save();
        $res = [
          'status' => 200,
          'statusText' => 'Nomor telepon berhasil diubah.'
        ];
      }
    }
    else
    {
      $getcustomer->customer_mobile_phone = $notelepon;
      $getcustomer->save();
      $res = [
        'status' => 200,
        'statusText' => 'Nomor telepon berhasil diubah.'
      ];
    }

    return response()->json( $res, $res['status'] );
  }

  public function rekeningbank( Request $request, Customers $customers, BankCustomer $bankcustomer )
  {
    if( Cookie::get('hasLoginCustomers') )
    {
      $datacustomer = $this->getcustomer( $customers, Cookie::get('customer_id') );
      return response()->view('frontend.pages.customers.rekeningbank', [
        'sessiondata' => $this->get_sessioncustomer(),
        'myaccount' => $datacustomer,
        'bankcustomer' => $bankcustomer->orderBy('bank_name', 'asc')->get()
      ]);
    }
    else
    {
      return response()->view('frontend.pages.customers.login');
    }
  }

  public function store_rekeningbank( Request $request, Customers $customers, CustomersBankAccount $customerba )
  {
    $bank = $request->bank;
    $pemilik = $request->pemilik;
    $rekening = $request->rekening;
    $customerba = new $customerba;
    $checkrekening = $customerba->where('account_number', $rekening)->count();
    $countrekening = $customerba->where('customer_id', Cookie::get('customer_id'))->count();
    if( $countrekening > 3 )
    {
      $res = [
        'status' => 422,
        'statusText' => 'Anda tidak dapat menambahkan rekening lagi.'
      ];
    }
    else if( $checkrekening === 1 )
    {
      $res = [
        'status' => 422,
        'statusText' => 'Nomor rekening sudah terdaftar'
      ];
    }
    else
    {
      $customerba->bank_id = $bank;
      $customerba->account_number = $rekening;
      $customerba->ownername = $pemilik;
      $customerba->customer_id = Cookie::get('customer_id');
      $customerba->save();
      $res = [
        'status' => 200,
        'statusText' => 'Nomor rekening baru berhasil ditambah.'
      ];
    }
    return response()->json( $res, $res['status'] );
  }
}
