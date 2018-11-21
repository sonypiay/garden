<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Database\Kecamatan;
use App\Http\Resources\KecamatanResource;
use App\Http\Controllers\Controller;

class KecamatanApi extends Controller
{
  public function all( Kecamatan $kecamatan )
  {
    $kecamatan = new $kecamatan;
    $query = $kecamatan->orderBy('nama_kec', 'asc')->get();
    return KecamatanResource::collection( $query );
  }

  public function byKabupaten( Kecamatan $kecamatan, $id )
  {
    $kecamatan = new $kecamatan;
    $query = $kecamatan->where('id_kab', $id)
    ->orderBy('nama_kec', 'asc')->get();
    return KecamatanResource::collection( $query );
  }
}
