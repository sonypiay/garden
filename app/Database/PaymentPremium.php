<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class PaymentPremium extends Model
{
  public $timestamps = true;
  protected $table = 'payment_subscription';
}
