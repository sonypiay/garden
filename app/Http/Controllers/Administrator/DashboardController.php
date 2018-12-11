<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\FunctionApp\CustomFunction;
use App\Database\BookingTransaction;
use App\Database\LogStatusTransaction;
use App\Http\Controllers\Controller;
use DateTime;
use DateInterval;
use DatePeriod;

class DashboardController extends Controller
{
  public function index( Request $request )
  {
    if( Cookie::get('hasLoginPanel') )
    {
      return response()->view('administrator.pages.dashboard', [
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

  public function total_current_analytic_transaction( Request $request, BookingTransaction $booking, LogStatusTransaction $logstatus )
  {
    $now = '2018-12-09';
    $payment_waiting = $booking->where([
      ['last_status_transaction', '=', 'payment_waiting'],
      [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $now]
    ])->count();
    $payment_verify = $booking->where([
      ['last_status_transaction', '=', 'payment_verify'],
      [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $now]
    ])->count();
    $paid = $booking->where([
      ['last_status_transaction', 'paid'],
      [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $now]
    ])->count();
    $onprogress = $booking->where([
      ['last_status_transaction', '=', 'onprogress'],
      [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $now]
    ])->count();
    $report = $booking->where([
      ['last_status_transaction', '=','report'],
      [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $now]
    ])->count();
    $done = $booking->where([
      ['last_status_transaction', '=', 'done'],
      [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $now]
    ])->count();

    $data = [
      'results' => [
        'payment_waiting' => $payment_waiting,
        'payment_verify' => $payment_verify,
        'paid' => $paid,
        'onprogress' => $onprogress,
        'report' => $report,
        'done' => $done
      ],
      'current_date' => $now
    ];
    return response()->json( $data, 200 );
  }

  public function analytic_activity_transaction( Request $request, LogStatusTransaction $logstatus )
  {
    $filter_day = $request->filter_day;
    $logstatus = new $logstatus;
    $dateformat = DB::raw('date_format(log_date, "%Y-%m-%d")');
    $begin = new DateTime(date('Y-m-d'));
    $end = new DateTime();

    if( $filter_day == 'today' )
    {
      $query = $logstatus->where( $dateformat, '=', date('Y-m-d') );
    }
    else if( $filter_day == '7day' )
    {
      $end = $end->modify( '7 days ago' );
      $interval = new DateInterval('P1D');
      $daterange = new DatePeriod($end, $interval , $begin);
      $range = [];
      foreach( $daterange as $date )
      {
        $range[] = $date->format('Y-m-d');
      }
      $startdate = $range[0];
      $enddate = end( $range );
      $query = $logstatus->where([
        [$dateformat, '>=', $startdate],
        [$dateformat, '<=', $enddate],
      ]);
    }
    else if( $filter_day == '14day' )
    {
      $end = $end->modify( '14 days ago' );
      $interval = new DateInterval('P1D');
      $daterange = new DatePeriod($end, $interval , $begin);
      $range = [];
      foreach( $daterange as $date )
      {
        $range[] = $date->format('Y-m-d');
      }
      $startdate = $range[0];
      $enddate = end( $range );
      $query = $logstatus->where([
        [$dateformat, '>=', $startdate],
        [$dateformat, '<=', $enddate],
      ]);
    }
    else if( $filter_day == '28day' )
    {
      $end = $end->modify( '28 days ago' );
      $interval = new DateInterval('P1D');
      $daterange = new DatePeriod($end, $interval , $begin);
      $range = [];
      foreach( $daterange as $date )
      {
        $range[] = $date->format('Y-m-d');
      }
      $startdate = $range[0];
      $enddate = end( $range );
      $query = $logstatus->where([
        [$dateformat, '>=', $startdate],
        [$dateformat, '<=', $enddate],
      ]);
    }
    else
    {
      $end = $end->modify( '1 month ago' );
      $interval = new DateInterval('P1D');
      $daterange = new DatePeriod($end, $interval , $begin);
      $range = [];
      foreach( $daterange as $date )
      {
        if( $date->format('Ym') == date('Ym') )
          $range[] = $date->format('Y-m-d');
      }
      $startdate = $range[0];
      $enddate = end( $range );
      $query = $logstatus->where([
        [$dateformat, '>=', $startdate],
        [$dateformat, '<=', $enddate],
      ]);
    }

    $data = [
      'results' => [
        'total' => $query->count(),
        'result' => $query->orderBy('log_date', 'desc')->get()
      ]
    ];
    return response()->json( $data );
  }

  public function total_vendor_customer( Vendors $vendors, Customers $customers )
  {
    $allvendors = $vendors->count();
    $vendor_registered_today = $vendors->where(DB::raw('date_format(vendor_registered, "%Y%m%d")'), '=', date('Ymd'))->count();

    $allcustomers = $customers->count();
    $customers_registered_today = $customers->where(DB::raw('date_format(customer_registered, "%Y%m%d")'), '=', date('Ymd'))->count();

    $data = [
      'vendor' => [
        'total_vendor' => $allvendors,
        'registered' => $vendor_registered_today
      ],
      'customers' => [
        'total_customer' => $allcustomers,
        'registered' => $customers_registered_today
      ]
    ];

    return response()->json( $data, 200 );
  }
}
