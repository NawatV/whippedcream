<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
  protected $table = 'patient';
  protected $primaryKey = 'patientId';
  public $incrementing = false;
  public $timestamps = false;
  protected $guarded = [];

  public function user()
  {
    return $this->belongsTo('App\Model\User', 'patientId', 'userId');
  }

  public function appointment()
  {
    return $this->hasMany('App\Model\Appointment', 'patientId', 'patientId');
  }

  public function vitalSignData()
  {
    return $this->hasMany('App\Model\VitalSignData', 'patientId', 'patientId');
  }

  public function diagnosis()
  {
    return $this->hasMany('App\Model\Diagnosis', 'patientId', 'patientId');
  }

}
