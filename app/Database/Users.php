<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
  use SoftDeletes;
  public $timestamps = true;
  protected $table = 'userspanel';
  protected $primaryKey = 'uid';
  protected $guarded = ['created_at','updated_at','deleted_at'];
}
