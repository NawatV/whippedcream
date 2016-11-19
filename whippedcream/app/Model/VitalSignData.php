<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VitalSignData extends Model
{
  protected $table = 'vitalSignData';
  protected $primaryKey = 'vitalSignDataId';
  public $timestamps = false;
  protected $guarded = [];

  public function patient()
  {
    return $this->belongsTo('App\Model\Patient', 'patientId', 'patientId');
  }

  public function nurse()
  {
    return $this->belongsTo('App\Model\Nurse', 'nurseId', 'nurseId');
  }

}
