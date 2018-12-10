<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class VendorReport extends Model
{
  public $timestamps = true;
  protected $table = 'vendor_report_transaction';
  protected $primaryKey = 'report_id';
}
