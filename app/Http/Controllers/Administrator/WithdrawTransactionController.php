<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\FunctionApp\CustomFunction;
use App\Database\Vendors;
use App\Database\Customers;
use App\Database\Withdraw;
use App\Http\Controllers\Controller;

class WithdrawTransactionController extends Controller
{
  use CustomFunction;

  public function index( Request $request,  )
  {
    if( Cookie::get('hasLoginPanel') )
    {
      return response()->view('administrator.pages.withdraw', [
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

  public function data_withdraw( Request $request, Withdraw $withdraw )
  {
    $rows = $request->rows;
    $keywords = $request->keywords;
    $status = $request->status;
    $withdraw = new $withdraw;
    if( empty( $keywords ) )
    {
      if( $status == 'all' )
      {
        $query = $withdraw->select(
          'withdraw.ticket_id',
          'withdraw.nominal',
          'withdraw.status_withdraw',
          'withdraw.created_at',
          'vendors.vendor_id',
          'vendors.vendor_name',
          'vendor_bankaccount.account_number',
          'vendor_bankaccount.ownername'
        )
        ->join('vendors', 'withdraw.vendor_id', '=', 'vendors.vendor_id')
        ->join('vendor_bankaccount', 'vendors.vendor_id', '=', 'withdraw.vendor_id')
        ->join('bankcustomer', 'vendor_bankaccount.vendor_bankid', '=', 'bankcustomer.bank_id')
      }
      else
      {
        $query = $withdraw->select(
          'withdraw.ticket_id',
          'withdraw.nominal',
          'withdraw.status_withdraw',
          'withdraw.created_at',
          'vendors.vendor_id',
          'vendors.vendor_name',
          'vendor_bankaccount.account_number',
          'vendor_bankaccount.ownername'
        )
        ->join('vendors', 'withdraw.vendor_id', '=', 'vendors.vendor_id')
        ->join('vendor_bankaccount', 'vendors.vendor_id', '=', 'withdraw.vendor_id')
        ->join('bankcustomer', 'vendor_bankaccount.vendor_bankid', '=', 'bankcustomer.bank_id')
        ->where('withdraw.status_withdraw', $status)
      }
    }
    else
    {
      if( $status == 'all' )
      {
        $query = $withdraw->select(
          'withdraw.ticket_id',
          'withdraw.nominal',
          'withdraw.status_withdraw',
          'withdraw.created_at',
          'vendors.vendor_id',
          'vendors.vendor_name',
          'vendor_bankaccount.account_number',
          'vendor_bankaccount.ownername'
        )
        ->join('vendors', 'withdraw.vendor_id', '=', 'vendors.vendor_id')
        ->join('vendor_bankaccount', 'vendors.vendor_id', '=', 'withdraw.vendor_id')
        ->join('bankcustomer', 'vendor_bankaccount.vendor_bankid', '=', 'bankcustomer.bank_id')
        ->where('withdraw.ticket_id', 'like', '%' . $keywords . '%')
        ->orWhere('vendors.vendor_name', 'like', '%' . $keywords . '%')
        ->orWhere('vendor_bankaccount.account_number', 'like', '%' . $keywords . '%')
      }
      else
      {
        $query = $withdraw->select(
          'withdraw.ticket_id',
          'withdraw.nominal',
          'withdraw.status_withdraw',
          'withdraw.created_at',
          'vendors.vendor_id',
          'vendors.vendor_name',
          'vendor_bankaccount.account_number',
          'vendor_bankaccount.ownername'
        )
        ->join('vendors', 'withdraw.vendor_id', '=', 'vendors.vendor_id')
        ->join('vendor_bankaccount', 'vendors.vendor_id', '=', 'withdraw.vendor_id')
        ->join('bankcustomer', 'vendor_bankaccount.vendor_bankid', '=', 'bankcustomer.bank_id')
        ->where([
          ['withdraw.status_withdraw', $status],
          ['withdraw.ticket_id', 'like', '%' . $keywords . '%']
        ])
        ->orWhere([
          ['withdraw.status_withdraw', $status],
          ['vendors.vendor_name', 'like', '%' . $keywords . '%']
        ])
        ->orWhere([
          ['withdraw.status_withdraw', $status],
          ['vendor_bankaccount.account_number', 'like', '%' . $keywords . '%']
        ])
      }
    }

    $result = $query->orderBy('vithdraw.created_at')
    ->paginate( $rows );

    $data = [
      'result' => [
        'total' => $result->.total()
        'data' => $result
      ]
    ];
    
    return response()->json( $data );
  }
}
