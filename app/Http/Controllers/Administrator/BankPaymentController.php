<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use App\Database\BankPayment;
use App\Http\Controllers\Controller;

class BankPaymentController extends Controller
{
  public function index( Request $request )
  {
    if( Cookie::get('hasLoginPanel') )
    {
      return response()->view('administrator.pages.bankpayment', [
        'request' => $request,
        'getSession' => $request->session(),
        'getCookies' => $request->cookie()
      ]);
    }
    else
    {
      return redirect( route('loginadminpage') );
    }
  }

  public function banklist( Request $request, BankPayment $bank )
  {
    $keywords = $request->keywords;
    $limit = 10;
    $bank = new $bank;
    if( $keywords === '' || empty( $keywords ) )
    {
      $query = $bank->orderBy('bank_id','desc')->paginate( $limit );
    }
    else
    {
      $query = $bank->where('bank_name', 'like', '%' . $keywords . '%')
      ->orWhere('bank_code', 'like', '%' . $keywords . '%')
      ->orderBy('bank_id','desc')->paginate( $limit );
    }

    return response()->json( $query, 200 );
  }

  public function store( Request $request, BankPayment $bank )
  {
    $bankcode = $request->bank_code;
    $bankname = $request->bank_name;
    $banklogo = $request->file('bank_logo');
    $getfilename = $banklogo->getClientOriginalName();
    $getsize = $banklogo->getClientSize();
    if( $getsize > 1024000 )
    {
      $res = [
        'status' => 413,
        'statusText' => 'Ukuran gambar terlalu besar. Makmsimal 1MB'
      ];
    }
    else
    {
      $query = new $bank;
      $check = $query->where('bank_code', '=', $bankcode);
      if( $check->count() == 1 )
      {
        $res = [
          'status' => 409,
          'statusText' => 'Kode bank sudah terdaftar.'
        ];
      }
      else
      {
        $query->bank_code = $bankcode;
        $query->bank_name = $bankname;
        $query->bank_logo = $getfilename;
        $query->save();
        Storage::disk('imagestorage')->putFileAs( 'bankpayment', $banklogo, $getfilename );

        $res = [
          'status' => 200,
          'statusText' => 'Bank pembayaran berhasil ditambah',
          'size' => $getsize
        ];
      }
    }
    return response()->json( $res, $res['status'] );
  }

  public function update( Request $request, BankPayment $bank, $id )
  {
    $bankcode = $request->bank_code;
    $bankname = $request->bank_name;
    $banklogo = $request->bank_logo;
    if( ! empty( $banklogo ) )
    {
      $getfilename = $banklogo->getClientOriginalName();
      $getsize = $banklogo->getClientSize();
    }

    $getbank = $bank->where('bank_id', $id)->first();
    if( $bankcode == $getbank->bank_code )
    {
      $getbank->bank_code = $bankcode;
      $getbank->bank_name = $bankname;

      if( ! empty( $banklogo ) )
      {
        if( $getsize > 1024000 )
        {
          $res = [
            'status' => 413,
            'statusText' => 'Ukuran gambar terlalu besar. Maksimal 1MB'
          ];
        }
        else
        {
          if( Storage::disk('imagestorage')->exists('bankpayment/' . $getbank->bank_logo) )
          {
            Storage::disk('imagestorage')->delete('bankpayment/' . $getbank->bank_logo);
          }
          Storage::disk('imagestorage')->putFileAs( 'bankpayment', $banklogo, $getfilename );
          $getbank->bank_logo = $getfilename;
          $getbank->save();
          $res = [
            'status' => 200,
            'statusText' => 'Bank pembayaran berhasil diupdate'
          ];
        }
      }
      else
      {
        $getbank->save();
        $res = [
          'status' => 200,
          'statusText' => 'Bank pembayaran berhasil diupdate'
        ];
      }
    }
    else
    {
      $check = $bank->where('bank_code', '=', $bankcode);
      if( $check->count() == 1 )
      {
        $res = [
          'status' => 409,
          'statusText' => 'Kode bank sudah terdaftar.'
        ];
      }
      else
      {
        $getbank->bank_code = $bankcode;
        $getbank->bank_name = $bankname;

        if( ! empty( $banklogo ) )
        {
          if( $getsize > 1024000 )
          {
            $res = [
              'status' => 413,
              'statusText' => 'Ukuran gambar terlalu besar. Maksimal 1MB'
            ];
          }
          else
          {
            if( Storage::disk('imagestorage')->exists('bankpayment/' . $getbank->bank_logo) )
            {
              Storage::disk('imagestorage')->delete('bankpayment/' . $getbank->bank_logo);
            }
            Storage::disk('imagestorage')->putFileAs( 'bankpayment', $banklogo, $getfilename );
            $getbank->bank_logo = $getfilename;
            $getbank->save();
            $res = [
              'status' => 200,
              'statusText' => 'Bank pembayaran berhasil diupdate'
            ];
          }
        }
        else
        {
          $getbank->save();
          $res = [
            'status' => 200,
            'statusText' => 'Bank pembayaran berhasil diupdate'
          ];
        }
      }
    }
    return response()->json( $res, $res['status'] );
  }

  public function destroy( BankPayment $bank, $id )
  {
    $query = $bank->where('bank_id', $id);
    $getbank = $query->first();
    if( $query->count() == 1 )
    {
      if( Storage::disk('imagestorage')->exists('bankpayment/' . $getbank->bank_logo) )
      {
        Storage::disk('imagestorage')->delete('bankpayment/' . $getbank->bank_logo);
      }
      $query->delete();
      $res = [
        'status' => 200,
        'statusText' => 'Bank berhasil dihapus'
      ];
    }
    else
    {
      $res = [
        'status' => 200,
        'statusText' => 'Bank berhasil dihapus'
      ];
    }
    return response()->json($res, $res['status']);
  }
}
