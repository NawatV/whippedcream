<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'userId';
    public $timestamps = false;
    protected $guarded = [];

    public function patient()
    {
        return $this->hasOne('App\Model\Patient', 'patientId', 'userId');
    }

    public function doctor()
    {
        return $this->hasOne('App\Model\Doctor', 'doctorId', 'userId');
    }

    public function nurse()
    {
        return $this->hasOne('App\Model\Nurse', 'nurseId', 'userId');
    }

    public function pharmacist()
    {
        return $this->hasOne('App\Model\Pharmacist', 'pharmacistId', 'userId');
    }

    public function staff()
    {
        return $this->hasOne('App\Model\Staff', 'staffId', 'userId');
    }

    public function admin()
    {
        return $this->hasOne('App\Model\Admin', 'adminId', 'userId');
    }
}
