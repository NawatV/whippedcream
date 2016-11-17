<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\VitalSignRequest;
use App\Http\Requests\DiagnosisRequest;

use App\Model\Nurse;
use App\Model\Patient;
use App\Model\Doctor;
use App\Model\VitalSignData;
use App\Model\Diagnosis;
use App\Model\Prescription;
use App\Model\Drug;

class TreatmentController extends Controller
{

    public function getVitalSignForm()
    {
      return view('vitalsign');
    }

    public function saveVitalSignForm(VitalSignRequest $request)
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
          return redirect()->back()->withInput()->withErrors(['ไม่มีรายชื่อผู้ป่วยภายในระบบ']);
      }

      $nurse = Nurse::find(4);

      $vitalSignData = new VitalSignData([
        'weight' => $weight,
        'height' => $height,
        'temperature' => $temperature,
        'pulse' => $pulse,
        'systolic' => $systolic,
        'diastolic' => $diastolic,
        'vitalSignDataDate' => date('Y-m-d')
      ]);

      $vitalSignData->patient()->associate($patient);
      $vitalSignData->nurse()->associate($nurse);
      $vitalSignData->save();
      return redirect('vitalsign');
    }

    public function getDiagnosisForm()
    {
      return view('diagnosis');
    }

    public function saveDiagnosisForm(DiagnosisRequest $request)
    {
      return redirect('diagnosis');
      $diagnosisForm = $request->except(['_token','firstname','lastname']);

      $patient = Patient::where('hn',$diagnosisForm['hn'])->first();

      if(count($patient) <= 0)
      {
          return redirect()->back()->withInput()->withErrors(['ไม่มีรายชื่อผู้ป่วยภายในระบบ']);
      }

      $doctor = Doctor::find(5);

      $diagnosis = new Diagnosis([
        'diagnosisDate' => date('Y-m-d'),
        'symptomcode' => $diagnosisForm['symptomcode'],
        'diagnosisDetail' => $diagnosisForm['details']
      ]);

      $diagnosis->patient()->associate($patient);
      $diagnosis->doctor()->associate($doctor);
      $diagnosis->save();

      if(count($diagnosisForm) > 3)
      {
        $prescription = new Prescription([
          'prescriptionDate' => date('Y-m-d')
        ]);
        $prescription->diagnosis()->associate($diagnosis);
        $prescription->save();

        $numDrug = (count($diagnosisForm) - 3)/3;

        for($i = 1; $i <= $numDrug; $i++)
        {
          $drug = new Drug([
            'drugName' => $diagnosisForm['drug'.$i],
            'drugUsage' => $diagnosisForm['usage'.$i],
            'drugAmount' => $diagnosisForm['quantity'.$i]
          ]);
          $drug->prescription()->associate($prescription);
          $drug->save();
        }
      }

      return redirect('diagnosis');
    }

}
