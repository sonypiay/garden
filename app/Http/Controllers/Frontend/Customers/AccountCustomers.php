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
        'request' => $request,
        'sessiondata' => $this->get_cookiescustomer(),
        'myaccount' => $datacustomer
      ]);
    }
    else
    {
      return response()->view('frontend.pages.customers.login', [
        'request' => $request
      ]);
    }
  }

  public function editprofile( Request $request, Customers $customers )
  {
    if( Cookie::get('hasLoginCustomers') )
    {
      $datacustomer = $this->getcustomer( $customers, Cookie::get('customer_id') );
      return response()->view('frontend.pages.customers.editaccount', [
        'request' => $request,
        'sessiondata' => $this->get_cookiescustomer(),
        'myaccount' => $datacustomer
      ]);
    }
    else
    {
      return response()->view('frontend.pages.customers.login', [
        'request' => $request
      ]);
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
        'request' => $request,
        'sessiondata' => $this->get_cookiescustomer(),
        'myaccount' => $datacustomer
      ]);
    }
    else
    {
      return response()->view('frontend.pages.customers.login', [
        'request' => $request
      ]);
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
        'request' => $request,
        'sessiondata' => $this->get_cookiescustomer(),
        'myaccount' => $datacustomer
      ]);
    }
    else
    {
      return response()->view('frontend.pages.customers.login', [
        'request' => $request
      ]);
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
          'status' => 409,
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
        'request' => $request,
        'sessiondata' => $this->get_cookiescustomer(),
        'myaccount' => $datacustomer
      ]);
    }
    else
    {
      return response()->view('frontend.pages.customers.login', [
        'request' => $request
      ]);
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
          'status' => 409,
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
        'request' => $request,
        'sessiondata' => $this->get_cookiescustomer(),
        'myaccount' => $datacustomer,
        'bankcustomer' => $bankcustomer->orderBy('bank_name', 'asc')->get()
      ]);
    }
    else
    {
      return response()->view('frontend.pages.customers.login', [
        'request' => $request
      ]);
    }
  }

  public function listrekeningbank( Request $request, CustomersBankAccount $rekening )
  {
    $rek = $rekening::leftJoin('bankcustomer', 'customer_bankaccount.bank_id', '=', 'bankcustomer.bank_id')
    ->where('customer_id', Cookie::get('customer_id'))
    ->get();
    return response()->json([
      'total' => $rek->count(),
      'data' => $rek
    ], 200);
  }

  public function store_rekeningbank( Request $request, Customers $customers, CustomersBankAccount $customerba )
  {
    $bank = $request->bank;
    $pemilik = $request->pemilik;
    $rekening = $request->rekening;
    $customerba = new $customerba;
    $checkrekening = $customerba->where('account_number', $rekening)->count();
    $countrekening = $customerba->where('customer_id', Cookie::get('customer_id'))->count();
    if( $checkrekening === 1 )
    {
      $res = [
        'status' => 409,
        'statusText' => 'Nomor rekening sudah terdaftar'
      ];
    }
    else if( $countrekening >= 3 )
    {
      $res = [
        'status' => 409,
        'statusText' => 'Anda hanya bisa menambahkan maksimal 3 rekening bank.'
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
        'statusText' => 'Rekening baru berhasil ditambah.'
      ];
    }
    return response()->json( $res, $res['status'] );
  }

  public function save_rekeningbank( Request $request, CustomersBankAccount $rekeningcustomer , $id )
  {
    $bank = $request->bank;
    $pemilik = $request->pemilik;
    $rekening = $request->rekening;
    $getrekening = $rekeningcustomer->where('id', $id)->first();
    if( $rekening == $getrekening->account_number )
    {
      $getrekening->bank_id = $bank;
      $getrekening->ownername = $pemilik;
      $getrekening->save();
      $res = [
        'status' => 200,
        'statusText' => 'Rekening bank berhasil diperbarui.'
      ];
    }
    else
    {
      $checkrekening = $rekeningcustomer->where('account_number', $rekening)->count();
      if( $checkrekening === 1 )
      {
        $res = [
          'status' => 409,
          'statusText' => 'Nomor rekening sudah terdaftar'
        ];
      }
      else
      {
        $getrekening->bank_id = $bank;
        $getrekening->account_number = $rekening;
        $getrekening->ownername = $pemilik;
        $getrekening->save();
        $res = [
          'status' => 200,
          'statusText' => 'Rekening bank berhasil diperbarui.'
        ];
      }
    }

    return response()->json( $res, $res['status'] );
  }

  public function delete_rekeningbank( Request $request, CustomersBankAccount $rekening , $id )
  {
    $result = $rekening->where('id', $id)->first();
    $res = [
      'status' => 200,
      'statusText' => 'Rekening ' . $result->account_number . ' berhasil dihapus.'
    ];
    $rekening->where('id', $id)->delete();
    return response()->json($res, $res['status']);
  }
}
