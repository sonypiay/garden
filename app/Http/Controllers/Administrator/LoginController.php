<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Database\Users;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
  public function index( Request $request )
  {
    if( Cookie::get('hasLoginPanel') )
    {
      return redirect( route('dashboard_admin') );
    }
    else
    {
      return response()->view('administrator.login', [
        'request' => $request,
        'getSession' => $request->session(),
        'getCookies' => $request->cookie()
      ]);
    }
  }

  public function dologin( Request $request, Users $users ) {
    $username = $request->username;
    $password = $request->password;

    $check = $users->where('username_panel','=',$username);
    if( $check->count() == 1 )
    {
      $fetch = $check->first();
      if( Hash::check( $password, $fetch->password_panel ) )
      {
        $result = ['statusText' => 'Login berhasil'];

        $expired_cookies = time() + 60 * 60 * 24 * 30;
        Cookie::queue(Cookie::make('ip', $request->server('REMOTE_ADDR'), $expired_cookies, '/'));
        Cookie::queue(Cookie::make('agent', $request->server('HTTP_USER_AGENT'), $expired_cookies, '/'));
        Cookie::queue(Cookie::make('logintime', time(), $expired_cookies, '/'));
        Cookie::queue(Cookie::make('userid', $fetch->uid, $expired_cookies, '/'));
        Cookie::queue(Cookie::make('hasLoginPanel', true, $expired_cookies, '/'));
        $result = ['statusText' => 'Login berhasil', 'status' => 200];
      }
      else
      {
        $result = ['statusText' => 'Password tidak benar', 'status' => 422];
      }
    }
    else
    {
      $result = ['statusText' => 'Akun ' . $username . ' tidak terdaftar', 'status' => 422];
    }

    return response()->json($result, $result['status']);
  }

  public function logout( Request $request)
  {
    if( Cookie::get('hasLoginPanel') )
    {
      Cookie::queue( Cookie::forget('ip') );
      Cookie::queue( Cookie::forget('agent') );
      Cookie::queue( Cookie::forget('logintime') );
      Cookie::queue( Cookie::forget('userid') );
      Cookie::queue( Cookie::forget('hasLoginPanel') );
    }
    return redirect( route('dashboard_admin') );
  }
}
