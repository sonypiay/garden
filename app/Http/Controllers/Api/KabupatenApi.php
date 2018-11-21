<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Database\Kabupaten;
use App\Http\Resources\KabupatenResource;
use App\Http\Controllers\Controller;

class KabupatenApi extends Controller
{
  public function all( Kabupaten $kabupaten )
  {
    $kabupaten = new $kabupaten;
    $query = $kabupaten->orderBy('nama_kab', 'asc')->get();
    return KabupatenResource::collection( $query );
  }

  public function byProvinsi( Kabupaten $kabupaten, $id )
  {
    $kabupaten = new $kabupaten;
    $query = $kabupaten->where('id_provinsi', $id)
    ->orderBy('nama_kab', 'asc')->get();
    return KabupatenResource::collection( $query );
  }
}
