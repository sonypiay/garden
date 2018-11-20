<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Database\Provinsi;
use App\Http\Controllers\Controller;

class ProvinsiController extends Controller
{
  public function index( Request $request )
  {
    if( Cookie::get('hasLoginPanel') )
    {
      return response()->view('administrator.pages.provinsi', [
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

  public function data_provinsi( Request $request, Provinsi $provinsi )
  {
    $keywords = $request->keywords;
    $rows = 10;
    $provinsi = new $provinsi;
    if( empty( $keywords ) )
    {
      $query = $provinsi->orderBy('id_provinsi', 'desc')
      ->paginate( $rows );
    }
    else
    {
      $query = $provinsi->where('kode_provinsi', 'like', '%' . $keywords . '%')
      ->orWhere('nama_provinsi', 'like', '%' . $keywords . '%')
      ->orderBy('id_provinsi', 'desc')
      ->paginate( $rows );
    }
    return response()->json( $query, 200 );
  }

  public function store( Request $request, Provinsi $provinsi )
  {

    $kode_provinsi = $request->kode_provinsi;
    $nama_provinsi = $request->nama_provinsi;
    $provinsi = new $provinsi;
    $checkkode = $provinsi->where('kode_provinsi', '=', $kode_provinsi)->count();
    if( $checkkode === 1 )
    {
      $res = [
        'status' => 409,
        'statusText' => 'Kode provinsi sudah terdaftar'
      ];
    }
    else
    {
      $provinsi->kode_provinsi = $kode_provinsi;
      $provinsi->nama_provinsi = $nama_provinsi;
      $provinsi->save();

      $res = [
        'status' => 200,
        'statusText' => 'Provinsi baru berhasil ditambah'
      ];
    }
    return response()->json( $res, $res['status'] );
  }

  public function update( Request $request, Provinsi $provinsi, $id )
  {
    $kode_provinsi = $request->kode_provinsi;
    $nama_provinsi = $request->nama_provinsi;
    $getprovinsi = $provinsi->where('id_provinsi', $id)->first();
    if( $getprovinsi->kode_provinsi == $kode_provinsi )
    {
      $getprovinsi->nama_provinsi = $nama_provinsi;
      $getprovinsi->save();
      $res = [
        'status' => 200,
        'statusText' => 'Provinsi berhasil diperbarui'
      ];
    }
    else
    {
      $checkkode = $provinsi->where('kode_provinsi', '=', $kode_provinsi)->count();
      if( $checkkode == 1 )
      {
        $res = [
          'status' => 409,
          'statusText' => 'Kode provinsi sudah terdaftar'
        ];
      }
      else
      {
        $getprovinsi->kode_provinsi = $kode_provinsi;
        $getprovinsi->nama_provinsi = $nama_provinsi;
        $getprovinsi->save();
        $res = [
          'status' => 200,
          'statusText' => 'Provinsi berhasil diperbarui'
        ];
      }
    }
    return response()->json( $res, $res['status'] );
  }

  public function destroy( Provinsi $provinsi, $id )
  {
    $getprovinsi = $provinsi->where('id_provinsi', $id)->first();
    $res = [
      'status' => 200,
      'statusText' => 'Provinsi ' . $getprovinsi->nama_provinsi . ' berhasil dihapus'
    ];
    $delete = $provinsi->where('id_provinsi', $id)->delete();
    return response()->json( $res, $res['status'] );
  }
}
