<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
  protected $table = 'department';
  protected $primaryKey = 'departmentId';
  public $timestamps = false;
  protected $guarded = [];

  public function doctor()
  {
    return $this->hasMany('App\Model\Doctor', 'departmentId', 'departmentId');
  }

  public function nurse()
  {
    return $this->hasMany('App\Model\Nurse', 'departmentId', 'departmentId');
  }

}
