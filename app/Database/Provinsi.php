<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
  public $timestamps = false;
  public $incrementing = false;
  protected $primaryKey = 'kode_provinsi';
  protected $table = 'provinsi';
}
