<?php

namespace App\Http\Controllers\Frontend\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\FunctionApp\CustomFunction;
use App\Database\Vendors;
use App\Database\Provinsi;
use App\Database\Kabupaten;
use App\Database\Kecamatan;
use App\Database\VendorBankAccount;
use App\Database\BankCustomer;
use App\Database\Withdraw;
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

  public function settingpage( Request $request )
  {
    if( Cookie::get('hasLoginVendor') )
    {
      $datavendor = $this->getvendors( new Vendors, Cookie::get('vendor_id') );
      return response()->view('frontend.pages.vendors.editaccount', [
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
    $deskripsi = $request->deskripsi;

    $vendor = $vendors->where('vendor_id', Cookie::get('vendor_id'))->first();
    $vendor->vendor_name = $vendor_name;
    $vendor->vendor_ownername = $ownername;
    $vendor->vendor_description = $deskripsi;
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

  public function save_mobileprivate( Request $request, Vendors $vendors )
  {
    $mobile_private = $this->replaceNumber( $request->mobile_private );
    $vendors = $vendors->where('vendor_id', Cookie::get('vendor_id'))->first();
    if( $vendors->vendor_mobile_private === $mobile_private )
    {
      $vendors->vendor_mobile_private = $mobile_private;
      $vendors->save();
      $res = [
        'status' => 200,
        'statusText' => 'Perubahan berhasil disimpan'
      ];
    }
    else
    {
      $checkphoneprivate = $vendors->where('vendor_mobile_private', $mobile_private)->count();
      $checkphonebusiness = $vendors->where([
        ['vendor_mobile_business', $mobile_private],
        ['vendor_id', '!=', Cookie::get('vendor_id')]
      ])->count();

      if( $checkphoneprivate === 1 )
      {
        $res = [
          'status' => 409,
          'statusText' => $mobile_private . ' sudah terdaftar.'
        ];
      }
      else if( $checkphonebusiness === 1 )
      {
        $res = [
          'status' => 409,
          'statusText' => $mobile_private . ' sudah terdaftar.'
        ];
      }
      else
      {
        $vendors->vendor_mobile_private = $mobile_private;
        $vendors->save();
        $res = [
          'status' => 200,
          'statusText' => 'Perubahan berhasil disimpan'
        ];
      }
    }
    return response()->json( $res, $res['status'] );
  }

  public function save_mobilebusiness( Request $request, Vendors $vendors )
  {
    $mobile_business = $this->replaceNumber( $request->mobile_business );
    $vendors = $vendors->where('vendor_id', Cookie::get('vendor_id'))->first();
    if( $vendors->vendor_mobile_business === $mobile_business )
    {
      $vendors->vendor_mobile_business = $mobile_business;
      $vendors->save();
      $res = [
        'status' => 200,
        'statusText' => 'Perubahan berhasil disimpan'
      ];
    }
    else
    {
      $checkphonebusiness = $vendors->where('vendor_mobile_business', $mobile_business)->count();
      $checkphoneprivate = $vendors->where([
        ['vendor_mobile_private', $mobile_business],
        ['vendor_id', '!=', Cookie::get('vendor_id')]
      ])->count();

      if( $checkphonebusiness === 1 )
      {
        $res = [
          'status' => 409,
          'statusText' => $mobile_business . ' sudah terdaftar.'
        ];
      }
      else if( $checkphoneprivate === 1 )
      {
        $res = [
          'status' => 409,
          'statusText' => $mobile_business . ' sudah terdaftar.'
        ];
      }
      else
      {
        $vendors->vendor_mobile_business = $mobile_business;
        $vendors->save();
        $res = [
          'status' => 200,
          'statusText' => 'Perubahan berhasil disimpan'
        ];
      }
    }
    return response()->json( $res, $res['status'] );
  }

  public function rekeningpencairan( Request $request, BankCustomer $bankcustomer )
  {
    if( Cookie::get('hasLoginVendor') )
    {
      $datavendor = $this->getvendors( new Vendors, Cookie::get('vendor_id') );
      return response()->view('frontend.pages.vendors.rekeningpencairan', [
        'request' => $request,
        'sessiondata' => Cookie::get(),
        'myaccount' => $datavendor,
        'bankcustomer' => $bankcustomer->orderBy('bank_name', 'asc')->get()
      ]);
    }
    else
    {
      return response()->view('frontend.pages.vendors.login', [
        'request' => $request
      ]);
    }
  }

  public function listrekeningbank( Request $request, VendorBankAccount $rekening )
  {
    $rek = $rekening::leftJoin('bankcustomer', 'vendor_bankaccount.bank_id', '=', 'bankcustomer.bank_id')
    ->where('vendor_id', Cookie::get('vendor_id'))
    ->get();
    return response()->json([
      'total' => $rek->count(),
      'data' => $rek
    ], 200);
  }

  public function store_rekeningbank( Request $request, VendorBankAccount $vendorba )
  {
    $bank = $request->bank;
    $pemilik = $request->pemilik;
    $rekening = $request->rekening;
    $vendorba = new $vendorba;
    $checkrekening = $vendorba->where('account_number', $rekening)->count();
    $countrekening = $vendorba->where('vendor_id', Cookie::get('vendor_id'))->count();
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
      $vendorba->bank_id = $bank;
      $vendorba->account_number = $rekening;
      $vendorba->ownername = $pemilik;
      $vendorba->vendor_id = Cookie::get('vendor_id');
      $vendorba->save();
      $res = [
        'status' => 200,
        'statusText' => 'Rekening baru berhasil ditambah.'
      ];
    }
    return response()->json( $res, $res['status'] );
  }

  public function save_rekeningbank( Request $request, VendorBankAccount $rekeningvendor , $id )
  {
    $bank = $request->bank;
    $pemilik = $request->pemilik;
    $rekening = $request->rekening;
    $getrekening = $rekeningvendor->where('id', $id)->first();
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
      $checkrekening = $rekeningvendor->where('account_number', $rekening)->count();
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

  public function delete_rekeningbank( Request $request, VendorBankAccount $rekening , $id )
  {
    $result = $rekening->where('id', $id)->first();
    $res = [
      'status' => 200,
      'statusText' => 'Rekening ' . $result->account_number . ' berhasil dihapus.'
    ];
    $rekening->where('id', $id)->delete();
    return response()->json($res, $res['status']);
  }

  public function brandinglogo( Request $request )
  {
    if( Cookie::get('hasLoginVendor') )
    {
      $datavendor = $this->getvendors( new Vendors, Cookie::get('vendor_id') );
      return response()->view('frontend.pages.vendors.brandinglogo', [
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

  public function uploadlogo( Request $request, Vendors $vendors )
  {
    $logo = $request->file('logo');
    $getfilename = hash('crc32b', bin2hex(time() . $logo->getClientOriginalName())) . $logo->getClientOriginalExtension();
    $getsize = $logo->getClientSize();
    if( $getsize > 2048000 )
    {
      $res = [
        'status' => 413,
        'statusText' => 'Ukuran gambar terlalu besar. Makmsimal 1MB'
      ];
    }
    else
    {
      $storage = Storage::disk('imagestorage');
      $vendor = $vendors->where('vendor_id', Cookie::get('vendor_id'))->first();
      if( $vendor->vendor_logo === '' )
      {
        $storage->putAsFile('vendor/logobrand', $logo, $getfilename);
      }
      else
      {
        if( $storage->exists('vendor/logobrand/' . $vendor->vendor_logo) )
        {
          $storage->delete('vendor/logobrand/' . $vendor->vendor_logo);
        }
        $storage->putFileAs('vendor/logobrand', $logo, $getfilename);
      }
      $vendor->vendor_logo = $getfilename;
      $vendor->save();

      $res = [
        'status' => 200,
        'statusText' => 'Logo berhasil diupload.'
      ];
    }
    return response()->json( $res );
  }
}
