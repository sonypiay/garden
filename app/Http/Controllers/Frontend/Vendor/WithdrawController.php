<?php

namespace App\Http\Controllers\Frontend\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\FunctionApp\CustomFunction;
use App\Database\Vendors;
use App\Database\VendorBankAccount;
use App\Database\Withdraw;
use App\Database\HistoryTransaction;
use App\Http\Controllers\Controller;

class WithdrawController extends Controller
{
  use CustomFunction;

  public function withdraw_page( Request $request, VendorBankAccount $vendorbank )
  {
    if( Cookie::get('hasLoginVendor') )
    {
      $datavendor = $this->getvendors( new Vendors, Cookie::get('vendor_id') );
      $vendorbank = $vendorbank->select(
        'vendor_bankaccount.account_number',
        'vendor_bankaccount.ownername',
        'bankcustomer.bank_id',
        'bankcustomer.bank_name'
      )
      ->join('bankcustomer', 'vendor_bankaccount.bank_id', '=', 'bankcustomer.bank_id')
      ->where('vendor_bankaccount.vendor_id', Cookie::get('vendor_id'))
      ->orderBy('account_number', 'asc')->get();
      return response()->view('frontend.pages.vendors.withdraw', [
        'request' => $request,
        'sessiondata' => Cookie::get(),
        'myaccount' => $datavendor,
        'vendorbank' => $vendorbank
      ]);
    }
    else
    {
      return redirect()->route('loginpage_vendor');
    }
  }

  public function process_withdraw( Request $request, Vendors $vendors, HistoryTransaction $history, Withdraw $withdraw )
  {
    $nominal = $request->nominal;
    $password = $request->password;
    $rekening = $request->rekening;
    $withdraw = new $withdraw;
    $vendors = $vendors->where('vendor_id', Cookie::get('vendor_id'))->first();
    $history = new $history;

    if( Hash::check( $password, $vendors->vendor_password ) )
    {
      $getid = $withdraw->orderBy('withdraw_id', 'desc')->count();
      $random = strtoupper( hash('crc32b', uniqid()) );
      $withdrawid = str_pad( $getid + 1, 4, '0', STR_PAD_LEFT );
      $ticketid = 'C' . date('Ymd') . substr( $random, 0, 3 ) . $withdrawid;
      $balances = $vendors->credits_balance - $nominal;

      $withdraw->ticket_id = $ticketid;
      $withdraw->vendor_bankid = $rekening;
      $withdraw->nominal = $nominal;
      $withdraw->status_withdraw = 'pending';
      $withdraw->vendor_id = $vendors->vendor_id;

      $history->history_type = 'withdraw';
      $history->history_transaction_id = $ticketid;
      $history->history_amount = $nominal;
      $history->history_current_amount = $balances;
      $history->history_description = 'Penarikan dana no. tiket ' . $ticketid;
      $history->vendor_id = $vendors->vendor_id;

      $vendors->credits_balance = $balances;

      $vendors->save();
      $history->save();
      $withdraw->save();

      $res = [
        'status' => 200,
        'statusText' => 'Pengajuan penarikan dana berhasil dibuat.'
      ];
    }
    else
    {
      $res = [
        'status' => 401,
        'statusText' => 'Kata sandi Anda salah.'
      ];
    }

    return response()->json( $res, $res['status'] );
  }

  public function history_transaction()
  {

  }
}
