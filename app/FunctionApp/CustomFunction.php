<?php

namespace App\FunctionApp;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

trait CustomFunction {

  public function getOSAgent( $agent )
  {
    $os = array(
			'iOS' => 'iPhone|iPad|iPod',
			'Android' => 'Android',
			'Windows' => 'Windows',
			'Ubuntu' => 'ubuntu',
			'Linux' => 'linux',
			'Mac OS' => 'Mac_PowerPC|Macintosh|Mac OS X',
		);

		foreach( $os as $os_info => $pattern )
		{
			$match = preg_match("/" . $pattern. "/i", $agent);
			if( $match )
				return $os_info;
		}
		return 'Unknown';
  }

  public function botfilter( $agent )
  {
    $bot_identifiers = array(
			'bot',
			'slurp',
			'crawler',
			'spider',
			'curl',
			'facebook',
			'twitterbot',
			'googlebot',
			'bingbot',
			'fetch',
			'trendsmap'
		);

		foreach( $bot_identifiers as $bot )
		{
			if( preg_match('/' . $bot . '/i', $agent) )
				return true;
		}
		return false;
  }

  public function get_cookiescustomer( $key = null )
  {
    if( $key === null )
    {
      $cookies = Cookie::get();
    }
    else
    {
      $cookies = Cookie::get( $key );
    }

    return $cookies;
  }

  public function get_sessioncustomer( $key = null )
  {
    if( $key === null )
    {
      return session()->all();
    }
    else
    {
      return session()->get( $key );
    }
  }

  public function getcustomer( $customer, $id )
  {
    $customer = $customer->where('customer_id', $id)->first();
    return $customer;
  }
}
