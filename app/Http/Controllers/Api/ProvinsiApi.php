<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Database\Provinsi;
use App\Http\Resources\ProvinsiResource;
use App\Http\Controllers\Controller;

class ProvinsiApi extends Controller
{
  public function all( Provinsi $provinsi )
  {
    $provinsi = new $provinsi;
    $query = $provinsi->orderBy('nama_provinsi', 'asc')->get();
    return ProvinsiResource::collection( $query );
  }
}
