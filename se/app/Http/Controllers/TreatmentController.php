<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\VitalSignRequest;
use App\Model\Nurse;
use App\Model\Patient;
use App\Model\VitalSignData;

class TreatmentController extends Controller
{

    public function getVitalSignForm()
    {
      return view('vitalsign');
    }

    public function save(VitalSignRequest $request)
    {
      $hn = $request->input('hn');
      $weight = $request->input('weight');
      $height = $request->input('height');
      $temperature = $request->input('temperature');
      $pulse = $request->input('pulse');
      $systolic = $request->input('systolic');
      $diastolic = $request->input('diastolic');

      $patient = Patient::where('hn',$hn)->first();

      if(count($patient) <= 0)
      {
          return redirect('vitalsign')->with('errors','ไม่มีรายชื่อผู้ป่วยภายในระบบ');
      }

      $nurse = Nurse::find(3);

      $vitalSignData = new VitalSignData([
        'weight' => $weight,
        'height' => $height,
        'temperature' => $temperature,
        'pulse' => $pulse,
        'systolic' => $systolic,
        'diastolic' => $diastolic,
        'vitalSignDataDate' => date('Y-m-d')
      ]);

      $vitalSignData->Patient()->associate($patient);
      $vitalSignData->Nurse()->associate($nurse);
      $vitalSignData->save();
      return redirect('vitalsign');
    }
}
