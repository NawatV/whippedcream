<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Leaving extends Model
{
  protected $table = 'leaving';
  protected $primaryKey = 'leavingId';
  public $timestamps = false;
  protected $guarded = [];

  public function doctor()
  {
    return $this->belongsTo('App\Model\Doctor', 'doctorId', 'doctorId');
  }
}
