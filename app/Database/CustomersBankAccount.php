<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class CustomersBankAccount extends Model
{
  public $timestamps = false;
  protected $primaryKey = 'id';
  protected $table = 'customer_bankaccount';
}
