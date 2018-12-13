<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
  public $timestamps = true;
  protected $table = 'messages';
  protected $primaryKey = 'msg_id';
}
