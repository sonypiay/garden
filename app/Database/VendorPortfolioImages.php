<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class VendorPortfolioImages extends Model
{
  public $timestamps = true;
  protected $table = 'vendor_portfolio_images';
  protected $primaryKey = 'images_id';
  protected $guarded = ['created_at','updated_at','deleted_at'];
}
