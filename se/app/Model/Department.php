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
    return $this->belongsToMany('App\Model\Doctor');
  }

  public function nurse()
  {
    return $this->belongsToMany('App\Model\Nurse');
  }

}
