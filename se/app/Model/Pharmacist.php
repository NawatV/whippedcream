<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pharmacist extends Model
{
  protected $table = 'pharmacist';
  protected $primaryKey = 'pharmacistId';
  public $incrementing = false;
  public $timestamps = false;
  protected $guarded = [];

  public function user()
  {
    return $this->belongsTo('App\Model\User', 'pharmacistId', 'userId');
  }

  public function petition()
  {
    return $this->hasMany('App\Model\Petition', 'pharmacistId', 'pharmacistId');
  }

  public function Prescription()
  {
    return $this->hasMany('App\Model\Prescription', 'pharmacistId', 'pharmacistId');
  }

}
