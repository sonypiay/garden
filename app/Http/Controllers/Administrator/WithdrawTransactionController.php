<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\FunctionApp\CustomFunction;
use App\Database\Vendors;
use App\Database\Customers;
use App\Database\Withdraw;
use App\Database\HistoryTransaction;
use App\Http\Controllers\Controller;

class WithdrawTransactionController extends Controller
{
  use CustomFunction;

  public function index( Request $request )
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
          'vendors.credits_balance',
          'vendor_bankaccount.account_number',
          'vendor_bankaccount.ownername',
          'bankcustomer.bank_name'
        )
        ->join('vendors', 'withdraw.vendor_id', '=', 'vendors.vendor_id')
        ->join('vendor_bankaccount', 'vendor_bankaccount.vendor_id', '=', 'withdraw.vendor_id')
        ->join('bankcustomer', 'vendor_bankaccount.bank_id', '=', 'bankcustomer.bank_id');
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
          'vendors.credits_balance',
          'vendor_bankaccount.account_number',
          'vendor_bankaccount.ownername',
          'bankcustomer.bank_name'
        )
        ->join('vendors', 'withdraw.vendor_id', '=', 'vendors.vendor_id')
        ->join('vendor_bankaccount', 'vendor_bankaccount.vendor_id', '=', 'withdraw.vendor_id')
        ->join('bankcustomer', 'vendor_bankaccount.bank_id', '=', 'bankcustomer.bank_id')
        ->where('withdraw.status_withdraw', $status);
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
          'vendors.credits_balance',
          'vendor_bankaccount.account_number',
          'vendor_bankaccount.ownername',
          'bankcustomer.bank_name'
        )
        ->join('vendors', 'withdraw.vendor_id', '=', 'vendors.vendor_id')
        ->join('vendor_bankaccount', 'vendor_bankaccount.vendor_id', '=', 'withdraw.vendor_id')
        ->join('bankcustomer', 'vendor_bankaccount.bank_id', '=', 'bankcustomer.bank_id')
        ->where('withdraw.ticket_id', 'like', '%' . $keywords . '%')
        ->orWhere('vendors.vendor_name', 'like', '%' . $keywords . '%')
        ->orWhere('vendor_bankaccount.account_number', 'like', '%' . $keywords . '%');
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
          'vendors.credits_balance',
          'vendor_bankaccount.account_number',
          'vendor_bankaccount.ownername',
          'bankcustomer.bank_name'
        )
        ->join('vendors', 'withdraw.vendor_id', '=', 'vendors.vendor_id')
        ->join('vendor_bankaccount', 'vendor_bankaccount.vendor_id', '=', 'withdraw.vendor_id')
        ->join('bankcustomer', 'vendor_bankaccount.bank_id', '=', 'bankcustomer.bank_id')
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
        ]);
      }
    }

    $result = $query->orderBy('withdraw.created_at', 'desc')
    ->paginate( $rows );

    $data = [
      'result' => $result
    ];

    return response()->json( $data );
  }

  public function approval_withdraw( Request $request, Withdraw $withdraw, Vendors $vendors, HistoryTransaction $history, $ticket )
  {
    $approval = $request->approval;
    $withdraw = $withdraw->where('ticket_id', $ticket)->first();
    $vendors = $vendors->where('vendor_id', $withdraw->vendor_id)->first();
    $history = $history->where([
      ['vendor_id', '=', $withdraw->vendor_id],
      ['history_transaction_id', '=', $ticket],
      ['history_type', '=', 'withdraw']
    ])->first();

    if( $approval == 'approve' )
    {
      $withdraw->status_withdraw = 'approved';
      $vendors->credits_balance = $vendors->credits_balance;

      $withdraw->save();
      $vendors->save();

      $res = [
        'status' => '200',
        'statusText' => 'Penarikan dana dengan ticket ' . $ticket . ' diapproved.'
      ];
    }
    else
    {
      $current_amount = $vendors->credits_balance + $withdraw->nominal;
      $vendors->credits_balance = $current_amount;

      $withdraw->status_withdraw = 'rejected';

      $withdraw->save();
      $vendors->save();

      $res = [
        'status' => '200',
        'statusText' => 'Penarikan dana dengan ticket ' . $ticket . ' direject.'
      ];
    }

    return response()->json( $res, $res['status'] );
  }
}
