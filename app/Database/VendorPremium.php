<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class VendorPremium extends Model
{
  public $timestamps = true;
  protected $table = 'vendor_premium';
  protected $primaryKey = 'subs_id';
}
