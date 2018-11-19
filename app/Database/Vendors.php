<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
  public $timestamps = false;
  public $incrementing = false;
  protected $table = 'vendors';
  protected $primaryKey = 'vendor_email_business';
}
