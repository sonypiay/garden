<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\FunctionApp\CustomFunction;
use App\Database\Customers;
use App\Database\Vendors;
use App\Database\VendorPremium;
use App\Database\PaymentPremium;
use App\Database\BankPayment;
use App\Http\Controllers\Controller;
use DateTime;
use DateInterval;

class HomepageController extends Controller
{
  use CustomFunction;

  public function index( Request $request, Cookie $cookie )
  {
    if( Cookie::get('hasLoginCustomers') )
    {
      $customer = $this->getcustomer( new Customers, Cookie::get('customer_id') );
      $data = [
        'request' => $request,
        'hasLogin' => true,
        'users' => $customer,
        'sessiondata' => Cookie::get()
      ];
    }
    else if( Cookie::get('hasLoginVendor') )
    {
      $vendors = $this->getvendors( new Vendors, Cookie::get('vendor_id') );
      $data = [
        'request' => $request,
        'hasLogin' => true,
        'users' => $vendors,
        'sessiondata' => Cookie::get()
      ];
    }
    else
    {
      $data = [
        'request' => $request,
        'hasLogin' => false,
        'users' => null,
        'sessiondata' => Cookie::get()
      ];
    }
    return response()->view('frontend.pages.homepage', $data);
  }

  public function aboutus( Request $request )
  {
    return response()->view('frontend.pages.aboutus');
  }

  public function loginpage( Request $request )
  {
    if( Cookie::get('hasLoginCustomers') || Cookie::get('hasLoginVendor') )
    {
      return redirect()->route('homepage');
    }
    else
    {
      return response()->view('frontend.pages.login', ['request' => $request]);
    }
  }

  public function signuppage( Request $request )
  {
    if( Cookie::get('hasLoginCustomers') || Cookie::get('hasLoginVendor') )
    {
      return redirect()->route('homepage');
    }
    else
    {
      return response()->view('frontend.pages.signup', ['request' => $request]);
    }
  }

  public function premium( Request $request, BankPayment $bankpayment )
  {
    if( Cookie::get('hasLoginVendor') )
    {
      $vendors = $this->getvendors( new Vendors, Cookie::get('vendor_id') );
      $data = [
        'request' => $request,
        'hasLogin' => true,
        'myaccount' => $vendors,
        'sessiondata' => Cookie::get()
      ];
    }
    else if( Cookie::get('hasLoginCustomers') )
    {
      $customer = $this->getcustomer( new Customers, Cookie::get('customer_id') );
      $data = [
        'request' => $request,
        'hasLogin' => true,
        'myaccount' => $customer,
        'sessiondata' => Cookie::get()
      ];
    }
    else
    {
      $data = [
        'request' => $request,
        'hasLogin' => false,
        'myaccount' => null,
        'sessiondata' => Cookie::get()
      ];
    }
    $data['bankpayment'] = $bankpayment->orderBy('bank_name', 'asc')->get();
    return response()->view('frontend.pages.premium', $data);
  }

  public function premium_checkout( Request $request, VendorPremium $premium, PaymentPremium $paymentpremium )
  {
    if( Cookie::get('hasLoginCustomers') )
    {
      $res = [
        'status' => 401,
        'statusText' => 'Maaf, fitur ini hanya untuk pemilik jasa taman hias.'
      ];
    }
    else
    {
      $bank = $request->bank;
      $price = $request->price;

      $date = new DateTime();
      $interval = new DateInterval('P1M');
      $date->add( $interval );
      $expired = $date->format('Y-m-d');
      $checkpremium = $premium->where('vendor_id', Cookie::get('vendor_id'));
      $orderid =  date('Ym') . substr( bin2hex( uniqid() ), 0, 3 );

      $paymentpremium = new $paymentpremium;
      $paymentpremium->payment_to = $bank;
      $paymentpremium->status_payment = 'pending';
      $paymentpremium->subs_order_id = $orderid;
      $paymentpremium->vendor_id = Cookie::get('vendor_id');
      $paymentpremium->save();

      if( $checkpremium->count() === 1 )
      {
        $checkpremium = $checkpremium->first();
        $checkpremium->subs_order_id = $orderid;
        $checkpremium->subs_expired = $expired;
        $checkpremium->vendor_id = Cookie::get('vendor_id');
        $checkpremium->is_verified = 'N';
        $checkpremium->save();

        $res = [
          'status' => 200,
          'statusText' => 'success',
          'order_id' => $orderid
        ];
      }
      else
      {
        $premium = new $premium;
        $premium->subs_order_id = $orderid;
        $premium->subs_expired = $expired;
        $premium->vendor_id = Cookie::get('vendor_id');
        $premium->is_verified = 'N';
        $premium->save();

        $res = [
          'status' => 200,
          'statusText' => 'success',
          'order_id' => $orderid
        ];
      }
    }
    return response()->json( $res, $res['status'] );
  }

  public function complete_payment_premium( Request $request, PaymentPremium $paymentpremium, $orderid )
  {
    $paymentpremium = $paymentpremium->join('vendors', 'payment_subscription.vendor_id', '=', 'vendors.vendor_id')
    ->join('bankpayment', 'payment_subscription.payment_to', '=', 'bankpayment.bank_id')
    ->where('payment_subscription.subs_order_id', $orderid);
    if( $paymentpremium->count() === 0 ) abort(404);

    $result = $paymentpremium->first();
    return response()->view('frontend.pages.complete_payment_premium', [
      'results' => $result,
      'request' => $request
    ]);
  }
}
