<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
  public $timestamps = true;
  protected $table = 'withdraw';
  protected $primaryKey = 'withdraw_id';
}
