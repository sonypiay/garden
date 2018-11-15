<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
  public $timestamps = false;
  protected $table = 'customers';
  protected $primaryKey = 'customer_email';
  public $incrementing = false;
}
