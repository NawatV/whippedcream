<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Petition extends Model
{
  protected $table = 'petition';
  protected $primaryKey = 'petitionId';
  public $timestamps = false;
  protected $guarded = [];

  public function doctor()
  {
    return $this->belongsTo('App\Model\Doctor', 'doctorId', 'doctorId');
  }

  public function pharmacist()
  {
    return $this->belongsTo('App\Model\Pharmacist', 'pharmacistId', 'pharmacistId');
  }
}
