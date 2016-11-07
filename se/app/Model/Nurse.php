<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
  protected $table = 'nurse';
  protected $primaryKey = 'nurseId';
  public $incrementing = false;
  public $timestamps = false;
  protected $guarded = [];

  public function user()
  {
    return $this->belongsTo('App\Model\User', 'nurseId', 'userId');
  }

  public function vitalSignData()
  {
    return $this->hasMany('App\Model\VitalSignData', 'nurseId', 'nurseId');
  }

  public function department()
  {
    return $this->belongsToMany('App\Model\Department', 'nurse_department', 'nurseId', 'departmentId');
  }

}
