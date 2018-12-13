<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\FunctionApp\CustomFunction;
use App\Database\Vendors;
use App\Database\Customers;
use App\Database\Kabupaten;
use App\Database\BookingTransaction;
use App\Database\LogStatusTransaction;
use App\Database\Withdraw;
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
    $now = date('Y-m-d');
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

  public function analytic_activity_transaction( Request $request, BookingTransaction $booking )
  {
    $filter_day = $request->filter_day;
    $rows = $request->rows;
    $keywords = $request->keywords;
    $premium = $request->premium;
    $status = $request->status;

    $booking = new $booking;
    $dateformat = DB::raw('date_format(booking_transaction.created_at, "%Y-%m-%d")');
    $begin = new DateTime(date('Y-m-d'));
    $end = new DateTime();
    $query = $booking->select(
      'vendors.vendor_name',
      'customers.customer_name',
      'booking_transaction.id',
      'booking_transaction.transaction_id',
      'booking_transaction.schedule_date',
      'booking_transaction.layout_design',
      'booking_transaction.payment_method',
      'booking_transaction.last_status_transaction',
      'booking_transaction.isPremium',
      'booking_transaction.created_at',
      'kabupaten.nama_kab'
    )
    ->join('customers', 'booking_transaction.customer_id', '=', 'customers.customer_id')
    ->join('vendors', 'booking_transaction.vendor_id', '=', 'vendors.vendor_id')
    ->join('kabupaten', 'booking_transaction.district', '=', 'kabupaten.id_kab');
    if( $filter_day == 'today' )
    {
      if( empty( $keywords ) )
      {
        if( $premium == 'all' )
        {
          if( $status == 'all' )
          {
            $query = $query->where( $dateformat, '=', date('Y-m-d') );
          }
          else
          {
            $query = $query->where([
              [$dateformat, '=', date('Y-m-d')],
              ['booking_transaction.last_status_transaction', '=', $status]
            ]);
          }
        }
        else
        {
          if( $status == 'all' )
          {
            $query = $query->where([
              [$dateformat, '=', date('Y-m-d')],
              ['booking_transaction.isPremium', '=', $premium]
            ]);
          }
          else
          {
            $query = $query->where([
              [$dateformat, '=', date('Y-m-d')],
              ['booking_transaction.isPremium', '=', $premium],
              ['booking_transaction.last_status_transaction', '=', $status]
            ]);
          }
        }
      }
      else
      {
        if( $premium == 'all' )
        {
          if( $status == 'all' )
          {
            $query = $query->where([
              [$dateformat, '=', date('Y-m-d')],
              ['booking_transaction.transaction_id', 'like', '%' . $keywords . '%']
            ])
            ->orWhere([
              [$dateformat, '=', date('Y-m-d')],
              ['customers.customer_name', 'like', '%' . $keywords . '%']
            ])
            ->orWhere([
              [$dateformat, '=', date('Y-m-d')],
              ['vendors.vendor_name', 'like', '%' . $keywords . '%']
            ]);
          }
          else
          {
            $query = $query->where([
              [$dateformat, '=', date('Y-m-d')],
              ['booking_transaction.last_status_transaction', '=', $status],
              ['booking_transaction.transaction_id', 'like', '%' . $keywords . '%']
            ])
            ->orWhere([
              [$dateformat, '=', date('Y-m-d')],
              ['booking_transaction.last_status_transaction', '=', $status],
              ['customers.customer_name', 'like', '%' . $keywords . '%']
            ])
            ->orWhere([
              [$dateformat, '=', date('Y-m-d')],
              ['booking_transaction.last_status_transaction', '=', $status],
              ['vendors.vendor_name', 'like', '%' . $keywords . '%']
            ]);
          }
        }
        else
        {
          if( $status == 'all' )
          {
            $query = $query->where([
              [$dateformat, '=', date('Y-m-d')],
              ['booking_transaction.isPremium', '=', $premium],
              ['booking_transaction.transaction_id', 'like', '%' . $keywords . '%']
            ]);
          }
          else
          {
            $query = $query->where([
              [$dateformat, '=', date('Y-m-d')],
              ['booking_transaction.isPremium', '=', $premium],
              ['booking_transaction.last_status_transaction', '=', $status],
              ['booking_transaction.transaction_id', 'like', '%' . $keywords . '%']
            ]);
          }
        }
      }
    }
    else
    {
      if( $filter_day == '7day' )
      {
        $end = $end->modify( '7 days ago' );
      }
      else if( $filter_day == '14day' )
      {
        $end = $end->modify( '14 days ago' );
      }
      else if( $filter_day == '28day' )
      {
        $end = $end->modify( '28 days ago' );
      }
      else
      {
        $end = $end->modify( '1 month ago' );
      }
      $interval = new DateInterval('P1D');
      $daterange = new DatePeriod($end, $interval , $begin);
      $range = [];

      if( $filter_day == 'this_month' )
      {
        foreach( $daterange as $date )
        {
          if( $date->format('Ym') == date('Ym')  )
            $range[] = $date->format('Y-m-d');
        }
      }
      else
      {
        foreach( $daterange as $date )
        {
            $range[] = $date->format('Y-m-d');
        }
      }

      $startdate = $range[0];
      $enddate = end( $range );

      if( empty( $keywords ) )
      {
        if( $premium == 'all' )
        {
          if( $status == 'all' )
          {
            $query = $query->where([
              [$dateformat, '>=', $startdate],
              [$dateformat, '<=', $enddate]
            ]);
          }
          else
          {
            $query = $query->where([
              [$dateformat, '>=', $startdate],
              [$dateformat, '<=', $enddate],
              ['booking_transaction.last_status_transaction', '=', $status]
            ]);
          }
        }
        else
        {
          if( $status == 'all' )
          {
            $query = $query->where([
              [$dateformat, '>=', $startdate],
              [$dateformat, '<=', $enddate],
              ['booking_transaction.isPremium', '=', $premium]
            ]);
          }
          else
          {
            $query = $query->where([
              [$dateformat, '>=', $startdate],
              [$dateformat, '<=', $enddate],
              ['booking_transaction.isPremium', '=', $premium],
              ['booking_transaction.last_status_transaction', '=', $status]
            ]);
          }
        }
      }
      else
      {
        if( $premium == 'all' )
        {
          if( $status == 'all' )
          {
            $query = $query->where([
              [$dateformat, '>=', $startdate],
              [$dateformat, '<=', $enddate],
              ['booking_transaction.transaction_id', 'like', '%' . $keywords . '%']
            ])
            ->orWhere([
              [$dateformat, '>=', $startdate],
              [$dateformat, '<=', $enddate],
              ['customers.customer_name', 'like', '%' . $keywords . '%']
            ])
            ->orWhere([
              [$dateformat, '>=', $startdate],
              [$dateformat, '<=', $enddate],
              ['vendors.vendor_name', 'like', '%' . $keywords . '%']
            ]);
          }
          else
          {
            $query = $query->where([
              [$dateformat, '>=', $startdate],
              [$dateformat, '<=', $enddate],
              ['booking_transaction.last_status_transaction', '=', $status],
              ['booking_transaction.transaction_id', 'like', '%' . $keywords . '%']
            ])
            ->orWhere([
              [$dateformat, '>=', $startdate],
              [$dateformat, '<=', $enddate],
              ['booking_transaction.last_status_transaction', '=', $status],
              ['customers.customer_name', 'like', '%' . $keywords . '%']
            ])
            ->orWhere([
              [$dateformat, '>=', $startdate],
              [$dateformat, '<=', $enddate],
              ['booking_transaction.last_status_transaction', '=', $status],
              ['vendors.vendor_name', 'like', '%' . $keywords . '%']
            ]);
          }
        }
        else
        {
          if( $status == 'all' )
          {
            $query = $query->where([
              [$dateformat, '>=', $startdate],
              [$dateformat, '<=', $enddate],
              ['booking_transaction.isPremium', '=', $premium],
              ['booking_transaction.transaction_id', 'like', '%' . $keywords . '%']
            ]);
          }
          else
          {
            $query = $query->where([
              [$dateformat, '>=', $startdate],
              [$dateformat, '<=', $enddate],
              ['booking_transaction.isPremium', '=', $premium],
              ['booking_transaction.last_status_transaction', '=', $status],
              ['booking_transaction.transaction_id', 'like', '%' . $keywords . '%']
            ]);
          }
        }
      }
    }

    $data = [
      'results' => $query->orderBy('booking_transaction.created_at', 'desc')->paginate( $rows ),
      'filterDay' => $filter_day
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

  public function analytic_withdraw( Withdraw $withdraw )
  {
    $approved = $withdraw->where('status_withdraw', '=', 'approved')->count();
    $pending = $withdraw->where('status_withdraw', '=', 'pending')->count();
    $rejected = $withdraw->where('status_withdraw', '=', 'rejected')->count();

    $data = [
      'result' => [
        'approved' => $approved,
        'pending' => $pending,
        'rejected' => $rejected
      ]
    ];

    return response()->json( $data, 200 );
  }
}
