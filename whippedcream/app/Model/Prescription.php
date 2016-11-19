<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
  protected $table = 'prescription';
  protected $primaryKey = 'prescriptionId';
  public $timestamps = false;
  protected $guarded = [];

  public function diagnosis()
  {
    return $this->belongsTo('App\Model\Diagnosis', 'diagnosisId', 'diagnosisId');
  }

  public function pharmacist()
  {
    return $this->belongsTo('App\Model\Pharmacist', 'pharmacistId', 'pharmacistId');
  }

  public function drug()
  {
    return $this->hasMany('App\Model\Drug', 'prescriptionId', 'prescriptionId');
  }

}
