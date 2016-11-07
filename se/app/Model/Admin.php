<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
  protected $table = 'admin';
  protected $primaryKey = 'adminId';
  public $incrementing = false;
  public $timestamps = false;
  protected $guarded = [];

  public function user()
  {
    return $this->belongsTo('App\Model\User', 'adminId', 'userId');
  }
}
