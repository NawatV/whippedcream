<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
  protected $table = 'drug';
  protected $primaryKey = 'drugId';
  public $timestamps = false;
  protected $guarded = [];

  public function prescription()
  {
    return $this->belongsTo('App\Model\Prescription', 'prescriptionId', 'prescriptionId');
  }

}
