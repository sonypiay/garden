<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class CustomersActivityLog extends Model
{
  public $timestamps = false;
  protected $table = 'cust_activity_logs';
  protected $primaryKey = 'customer_email';
}
