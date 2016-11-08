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

       $patient = Patient::select('patientId')->where('hn',$hn)->get();
       return get_class($patient);
      // $patientId;
      // foreach ($patient as $p) {
      //   $patientId = $p->patientId;
      // }
      $patient = Patient::find(1);

      $nurse = Nurse::find(2);
      $vitalSignData = new VitalSignData;
      $vitalSignData->weight = $weight;
      $vitalSignData->height = $height;
      $vitalSignData->temperature = $temperature;
      $vitalSignData->pulse = $pulse;
      $vitalSignData->systolic = $systolic;
      $vitalSignData->diastolic = $diastolic;
      $vitalSignData->vitalSignDataDate = date('Y-m-d');

      $vitalSignData->Patient()->associate($patient);
      $vitalSignData->Nurse()->associate($nurse);
      $vitalSignData->save();
      return redirect('vitalsign');
    }
}
