<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class LogStatusTransaction extends Model
{
  public $timestamps = false;
  protected $table = 'log_status_transaction';
  protected $primaryKey = 'id';
}
