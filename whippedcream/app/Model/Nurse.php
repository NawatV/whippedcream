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

  public function department()
  {
    return $this->belongsTo('App\Model\Department', 'departmentId', 'departmentId');
  }

  public function vitalSignData()
  {
    return $this->hasMany('App\Model\VitalSignData', 'nurseId', 'nurseId');
  }

}
