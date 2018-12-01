<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class BookingTransaction extends Model
{
  public $timestamps = true;
  protected $table = 'booking_transaction';
  protected $primaryKey = 'booking_id';
  public $incrementing = false;
}
