<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class CustomersBankAccount extends Model
{
  public $timestamps = true;
  protected $table = 'customer_bankaccount';
}
