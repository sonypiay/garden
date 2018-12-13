<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\FunctionApp\CustomFunction;
use App\Database\Vendors;
use App\Database\Customers;
use App\Database\BookingTransaction;
use App\Database\LogStatusTransaction;
use App\Http\Controllers\Controller;
use DateTime;
use DatePeriod;
use DateInterval;

class ReportsController extends Controller
{
  public function order_transaction( Request $request, BookingTransaction $booking )
  {
    $filter_day = $request->filter_day;
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
      'results' => $query->orderBy('booking_transaction.created_at', 'desc')->get(),
      'filterDay' => $filter_day
    ];
    return response()->view( 'administrator.reports.orderlist', $data);
  }
}
