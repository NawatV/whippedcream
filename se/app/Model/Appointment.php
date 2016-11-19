<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
  protected $table = 'appointment';
  protected $primaryKey = 'appointmentId';
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

}
