<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProvinsiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return [
        'id' => $this->id_provinsi,
        'nama' => $this->nama_provinsi,
        'kode' => $this->kode_provinsi
      ];
    }
    
    public function with($request)
    {
      return [
        'meta' => [
          'author' => 'Sony Darmawan',
          'email' => 'me@sonypiay.com',
          'website' => 'https://www.sonypiay.com'
        ]
      ];
    }

    public function withResponse($request, $response)
    {
      $response->header('Content-Type', 'application/json');
      $response->header('Accepts', 'application/json');
    }
}
