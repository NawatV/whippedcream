<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
  protected $table = 'doctor';
  protected $primaryKey = 'doctorId';
  public $incrementing = false;
  public $timestamps = false;
  protected $guarded = [];

  public function user()
  {
    return $this->belongsTo('App\Model\User', 'doctorId', 'userId');
  }

  public function department()
  {
    return $this->belongsTo('App\Model\Department', 'departmentId', 'departmentId');
  }

  public function schedule()
  {
    return $this->hasOne('App\Model\Schedule', 'doctorId', 'doctorId');
  }

  public function appointment()
  {
    return $this->hasMany('App\Model\Appointment', 'doctorId', 'doctorId');
  }

  public function leaving()
  {
    return $this->hasMany('App\Model\Leaving', 'doctorId', 'doctorId');
  }

  public function petition()
  {
    return $this->hasMany('App\Model\Petition', 'doctorId', 'doctorId');
  }

  public function diagnosis()
  {
    return $this->hasMany('App\Model\Diagnosis', 'doctorId', 'doctorId');
  }

}
