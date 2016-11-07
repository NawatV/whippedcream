<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
  protected $table = 'staff';
  protected $primaryKey = 'staffId';
  public $incrementing = false;
  public $timestamps = false;
  protected $guarded = [];

  public function user()
  {
    return $this->belongsTo('App\Model\User', 'staffId', 'userId');
  }
}
