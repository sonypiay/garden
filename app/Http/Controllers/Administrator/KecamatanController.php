<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Database\Kabupaten;
use App\Database\Kecamatan;
use App\Http\Controllers\Controller;

class KecamatanController extends Controller
{
  public function index( Request $request, Kabupaten $kabupaten )
  {
    if( Cookie::get('hasLoginPanel') )
    {
      return response()->view('administrator.pages.kecamatan', [
        'request' => $request,
        'getSession' => $request->session(),
        'getCookies' => $request->cookie(),
        'kabupaten' => $kabupaten->orderBy('nama_kab', 'asc')->get()
      ]);
    }
    else
    {
      return redirect( route('loginadminpage') );
    }
  }

  public function data_kecamatan( Request $request, Kecamatan $kecamatan )
  {
    $keywords = $request->keywords;
    $rows = 10;
    $kecamatan = new $kecamatan;
    if( empty( $keywords ) )
    {
      $query = $kecamatan->join('kabupaten', 'kecamatan.id_kab', '=', 'kabupaten.id_kab')
      ->orderBy('kecamatan.id_kec', 'desc')
      ->paginate( $rows );
    }
    else
    {
      $query = $kecamatan->join('kabupaten', 'kecamatan.id_kab', '=', 'kabupaten.id_kab')
      ->where('kode_kec', 'like', '%' . $keywords . '%')
      ->orWhere('nama_kec', 'like', '%' . $keywords . '%')
      ->orWhere('nama_kab', 'like', '%' . $keywords . '%')
      ->orderBy('kecamatan.id_kec', 'desc')
      ->paginate( $rows );
    }
    return response()->json( $query, 200 );
  }

  public function store( Request $request, Kecamatan $kecamatan )
  {
    $kode_kec = $request->kode_kec;
    $nama_kecamatan = $request->nama_kecamatan;
    $kabupaten = $request->kabupaten;
    $kecamatan = new $kecamatan;
    $checkkode = $kecamatan->where('kode_kec', '=', $kode_kec)->count();
    if( $checkkode === 1 )
    {
      $res = [
        'status' => 409,
        'statusText' => 'Kode kecamatan sudah terdaftar'
      ];
    }
    else
    {
      $kecamatan->kode_kec = $kode_kec;
      $kecamatan->nama_kec = $nama_kecamatan;
      $kecamatan->id_kab = $kabupaten;
      $kecamatan->save();

      $res = [
        'status' => 200,
        'statusText' => 'Kecamatan baru berhasil ditambah'
      ];
    }
    return response()->json( $res, $res['status'] );
  }

  public function update( Request $request, Kecamatan $kecamatan, $id )
  {
    $kode_kec = $request->kode_kec;
    $nama_kecamatan = $request->nama_kecamatan;
    $kabupaten = $request->kabupaten;
    $getkecamatan = $kecamatan->where('id_kec', $id)->first();
    if( $getkecamatan->kode_kec == $kode_kec )
    {
      $getkecamatan->nama_kec = $nama_kecamatan;
      $getkecamatan->id_kab = $kabupaten;
      $getkecamatan->save();
      $res = [
        'status' => 200,
        'statusText' => 'Kecamatan berhasil diperbarui'
      ];
    }
    else
    {
      $checkkode = $kecamatan->where('kode_kec', '=', $kode_kec)->count();
      if( $checkkode == 1 )
      {
        $res = [
          'status' => 409,
          'statusText' => 'Kode kecamatan sudah terdaftar'
        ];
      }
      else
      {
        $getkecamatan->kode_kec = $kode_kec;
        $getkecamatan->nama_kec = $nama_kecamatan;
        $getkecamatan->id_kab = $kabupaten;
        $getkecamatan->save();
        $res = [
          'status' => 200,
          'statusText' => 'Kecamatan berhasil diperbarui'
        ];
      }
    }
    return response()->json( $res, $res['status'] );
  }

  public function destroy( Kecamatan $kecamatan, $id )
  {
    $getkecamatan = $kecamatan->where('id_kec', $id)->first();
    $res = [
      'status' => 200,
      'statusText' => 'Kecamatan ' . $getkecamatan->nama_kec . ' berhasil dihapus'
    ];
    $delete = $kecamatan->where('id_kec', $id)->delete();
    return response()->json( $res, $res['status'] );
  }
}
