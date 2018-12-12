<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class HistoryTransaction extends Model
{
  public $timestamps = true;
  protected $table = 'vendor_history_transaction';
  protected $primaryKey = 'history_id';
}
