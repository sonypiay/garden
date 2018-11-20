<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
  public $timestamps = false;
  public $incrementing = false;
  protected $primaryKey = 'kode_kab';
  protected $table = 'kabupaten';
}
