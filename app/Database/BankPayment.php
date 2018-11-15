<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class BankPayment extends Model
{
  public $timestamps = true;
  protected $table = 'bankpayment';
  protected $primaryKey = 'bank_id';
  protected $guarded = ['created_at','updated_at'];
}
