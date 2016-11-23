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
  			   //->belongsTo('App\User', 'foreign_key', 'other_key');
  	//https://laravel.com/docs/5.3/eloquent-relationships#updating-belongs-to-relationships
    return $this->belongsTo('App\Model\Doctor', 'doctorId', 'doctorId');
  }

 public function staff()
  {
    return $this->belongsTo('App\Model\Staff', 'staffId', 'staffId'); 
  }


}
