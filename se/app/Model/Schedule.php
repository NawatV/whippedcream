<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
  protected $table = 'schedule';
  protected $primaryKey = 'scheduleId';
  public $timestamps = false;
  protected $guarded = [];

  public function doctor()
  {
    return $this->belongsTo('App\Model\Doctor', 'doctorId', 'doctorId');
  }

}
