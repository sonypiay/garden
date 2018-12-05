<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class PaymentOrderVerify extends Model
{
  public $timestammps = false;
  protected $table = 'payment_order_verify';
}
