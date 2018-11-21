<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
  public $timestamps = false;
  public $incrementing = false;
  protected $primaryKey = 'kode_kec';
  protected $table = 'kecamatan';
}
