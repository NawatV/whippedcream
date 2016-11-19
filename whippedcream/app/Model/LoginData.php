<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LoginData extends Model
{
  protected $table = 'user';
  protected $primaryKey = 'username';
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

  public function doctor()
  {
    return $this->belongsTo('App\Model\Doctor', 'doctorId', 'doctorId');
  }

  public function pharmacist()
  {
    return $this->belongsTo('App\Model\Pharmacist', 'pharmacistId', 'pharmacistId');
  }

  public function staff()
  {
    return $this->belongsTo('App\Model\Staff', 'staffId', 'staffId');
  }

  public function admin()
  {
    return $this->belongsTo('App\Model\Admin', 'adminId', 'adminId');
  }

}
