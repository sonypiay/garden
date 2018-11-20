<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Database\Kabupaten;
use App\Database\Provinsi;
use App\Http\Controllers\Controller;

class KabupatenController extends Controller
{
  public function index( Request $request, Provinsi $provinsi )
  {
    if( Cookie::get('hasLoginPanel') )
    {
      return response()->view('administrator.pages.kabupaten', [
        'request' => $request,
        'getSession' => $request->session(),
        'getCookies' => $request->cookie(),
        'provinsi' => $provinsi->orderBy('nama_provinsi', 'asc')->get()
      ]);
    }
    else
    {
      return redirect( route('loginadminpage') );
    }
  }

  public function data_kabupaten( Request $request, Kabupaten $kabupaten )
  {
    $keywords = $request->keywords;
    $rows = 10;
    $kabupaten = new $kabupaten;
    if( empty( $keywords ) )
    {
      $query = $kabupaten->join('provinsi', 'kabupaten.id_provinsi', '=', 'provinsi.id_provinsi')
      ->orderBy('kabupaten.id_kab', 'desc')
      ->paginate( $rows );
    }
    else
    {
      $query = $kabupaten->join('provinsi', 'kabupaten.id_provinsi', '=', 'provinsi.id_provinsi')
      ->where('kode_kab', 'like', '%' . $keywords . '%')
      ->orWhere('nama_kab', 'like', '%' . $keywords . '%')
      ->orWhere('nama_provinsi', 'like', '%' . $keywords . '%')
      ->orderBy('kabupaten.id_kab', 'desc')
      ->paginate( $rows );
    }
    return response()->json( $query, 200 );
  }

  public function store( Request $request, Kabupaten $kabupaten )
  {
    $kode_kab = $request->kode_kab;
    $nama_kabupaten = $request->nama_kabupaten;
    $provinsi = $request->provinsi;
    $kabupaten = new $kabupaten;
    $checkkode = $kabupaten->where('kode_kab', '=', $kode_kab)->count();
    if( $checkkode === 1 )
    {
      $res = [
        'status' => 409,
        'statusText' => 'Kode kabupaten sudah terdaftar'
      ];
    }
    else
    {
      $kabupaten->kode_kab = $kode_kab;
      $kabupaten->nama_kab = $nama_kabupaten;
      $kabupaten->id_provinsi = $provinsi;
      $kabupaten->save();

      $res = [
        'status' => 200,
        'statusText' => 'Kabupaten baru berhasil ditambah'
      ];
    }
    return response()->json( $res, $res['status'] );
  }

  public function update( Request $request, Kabupaten $kabupaten, $id )
  {
    $kode_kab = $request->kode_kab;
    $nama_kabupaten = $request->nama_kabupaten;
    $provinsi = $request->provinsi;
    $getkabupaten = $kabupaten->where('id_kab', $id)->first();
    if( $getkabupaten->kode_kab == $kode_kab )
    {
      $getkabupaten->nama_kab = $nama_kabupaten;
      $getkabupaten->id_provinsi = $provinsi;
      $getkabupaten->save();
      $res = [
        'status' => 200,
        'statusText' => 'Kabupaten berhasil diperbarui'
      ];
    }
    else
    {
      $checkkode = $kabupaten->where('kode_kab', '=', $kode_kab)->count();
      if( $checkkode == 1 )
      {
        $res = [
          'status' => 409,
          'statusText' => 'Kode kabupaten sudah terdaftar'
        ];
      }
      else
      {
        $getkabupaten->kode_kab = $kode_kab;
        $getkabupaten->nama_kab = $nama_kabupaten;
        $getkabupaten->id_provinsi = $provinsi;
        $getkabupaten->save();
        $res = [
          'status' => 200,
          'statusText' => 'Kabupaten berhasil diperbarui'
        ];
      }
    }
    return response()->json( $res, $res['status'] );
  }

  public function destroy( Kabupaten $kabupaten, $id )
  {
    $getkabupaten = $kabupaten->where('id_kab', $id)->first();
    $res = [
      'status' => 200,
      'statusText' => 'Kabupaten ' . $getkabupaten->nama_kab . ' berhasil dihapus'
    ];
    $delete = $kabupaten->where('id_kab', $id)->delete();
    return response()->json( $res, $res['status'] );
  }
}
