<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class PaymentOrderVerify extends Model
{
  public $timestamps = true;
  protected $table = 'payment_order_verify';
  protected $guarded = ['created_at','updated_at'];
}
