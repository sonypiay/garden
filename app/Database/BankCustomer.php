<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class BankCustomer extends Model
{
  public $timestamps = true;
  protected $table = 'bankcustomer';
  protected $primaryKey = 'bank_id';
  protected $guarded = ['created_at','updated_at'];
}
