<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class VendorPortfolio extends Model
{
  public $timestamps = true;
  protected $table = 'vendor_portfolio';
  protected $primaryKey = 'portfolio_id';
  protected $guarded = ['created_at','updated_at','deleted_at'];
}
