<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
  protected $table = 'diagnosis';
  protected $primaryKey = 'diagnosisId';
  public $timestamps = false;
  protected $guarded = [];

  public function patient()
  {
    return $this->belongsTo('App\Model\Patient', 'patientId', 'patientId');
  }

  public function doctor()
  {
    return $this->belongsTo('App\Model\Doctor', 'doctorId', 'doctorId');
  }

  public function prescription()
  {
    return $this->hasOne('App\Model\Prescription', 'diagnosisId', 'diagnosisId');
  }

}
