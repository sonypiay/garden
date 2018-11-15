<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Database\Users;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class UsersController extends Controller
{
  public function index( Request $request, Users $users )
  {
    if( Cookie::get('hasLoginPanel') )
    {
      return response()->view('administrator.pages.users', [
        'request' => $request,
        'getSession'  => $request->session(),
        'getCookies' => $request->cookie()
      ]);
    }
    else
    {
      return redirect( route('loginadminpage') );
    }
  }

  public function datauser( Request $request, Users $users )
  {
    $searchuser = $request->searchuser;
    $limit = $request->limit;

    $users = new $users;
    if( empty( $searchuser ) )
    {
      $query = $users->orderBy('uid','asc')->paginate($limit);
    }
    else
    {
      $query = $users->where('fullname', 'like', '%' . $searchuser . '%')
      ->orWhere('username_panel', 'like', '%' . $searchuser . '%')
      ->orWhere('email', 'like', '%' . $searchuser . '%')
      ->orderBy('uid','asc')
      ->paginate($limit);
    }

    if( ! $query ) abort(500);

    $data = [
      'results' => $query
    ];
    return response()->json($data, 200);
  }

  public function store( Request $request, Users $users )
  {
    $fullname = $request->fullname;
    $username = $request->username;
    $password = $request->password;
    $email = $request->email;
    $privilege = $request->privilege;
    $users = new $users;
    $checkemail = $users->where('email', '=', $email)->count();
    $checkusername = $users->where('username_panel','=', $username)->count();

    if( $checkemail == 1 )
    {
      $res = [
        'status' => 422,
        'statusText' => 'Email ' . $email . ' sudah terdaftar'
      ];
    }
    else if( $checkusername == 1 )
    {
      $res = [
        'status' => 422,
        'statusText' => 'Username ' . $username . ' sudah terdaftar'
      ];
    }
    else
    {
      $users->fullname = $fullname;
      $users->username_panel = $username;
      $users->password_panel =  Hash::make( $password );
      $users->privileges_user = $privilege;
      $users->email = $email;
      $users->save();
      $res = [
        'status' => 200,
        'statusText' => 'User ' . $username . ' berhasil ditambahkan'
      ];
    }
    return response()->json( $res, $res['status'] );
  }

  public function update( Request $request, Users $users, $id )
  {
    $fullname = $request->fullname;
    $username = $request->username;
    $password = $request->password;
    $email = $request->email;
    $privilege = $request->privilege;
    $getuser = $users->where('uid', $id)->first();
    if( $getuser->username_panel == $username )
    {
      $getuser->fullname = $fullname;
      $getuser->username_panel = $username;
      if( ! empty( $password ) ) $getuser->password_panel =  Hash::make( $password );
      $getuser->privileges_user = $privilege;
      $getuser->email = $email;
      $getuser->save();
      $res = [
        'status' => 200,
        'statusText' => 'Perubahan berhasil disimpan.'
      ];
    }
    else
    {
      $check = $users->where('username_panel', '=', $username);
      if( $check->count() == 1 )
      {
        $res = [
          'status' => 409,
          'statusText' => 'Username sudah terdaftar'
        ];
      }
      else
      {
        $getuser->fullname = $fullname;
        $getuser->username_panel = $username;
        if( ! empty( $password ) ) $getuser->password_panel =  Hash::make( $password );
        $getuser->privileges_user = $privilege;
        $getuser->email = $email;
        $getuser->save();
        $res = [
          'status' => 200,
          'statusText' => 'Perubahan berhasil disimpan.'
        ];
      }
    }

    return response()->json($res, $res['status']);
  }
}
