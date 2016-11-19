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
  //------------- vialSign -------------------------------------------
    public function getVitalSignForm()
    {
      return view('vitalsign');
    }

    public function saveVitalSignForm(VitalSignRequest $request)
    {
      //------ get inputs-----------------
      $hn = $request->input('hn');
      $weight = $request->input('weight');
      $height = $request->input('height');
      $temperature = $request->input('temperature');
      $pulse = $request->input('pulse');
      $systolic = $request->input('systolic');
      $diastolic = $request->input('diastolic');

      $patient = Patient::where('hn',$hn)->first(); //query in DB
      if(count($patient) <= 0)
      {
          return redirect()->back()->withInput()->withErrors(['ไม่มีรายชื่อผู้ป่วยภายในระบบ']); 
          //these methods belongs to Laravel (go to the page with error msg)
      }

      //******** belongs to relationship *********
      //*1. identiy that this means "nurse whose id=4"
      $nurse = Nurse::find(4);  

      //------ keep data in a new VitalSignData as 'key'=>'$value' --------------
      $vitalSignData = new VitalSignData([
        'weight' => $weight,
        'height' => $height,
        'temperature' => $temperature,
        'pulse' => $pulse,
        'systolic' => $systolic,
        'diastolic' => $diastolic,
        'vitalSignDataDate' => date('Y-m-d')
      ]);
      //*2. $vitalSignData belongs to $patient
      $vitalSignData->patient()->associate($patient);
      $vitalSignData->nurse()->associate($nurse);
      //*3. save $vitalSignData
      $vitalSignData->save();

      return redirect('vitalsign');
    }

  //------------- diagnosisForm -------------------------------------------
    public function getDiagnosisForm()
    {
      return view('diagnosis');
    }

    public function saveDiagnosisForm(DiagnosisRequest $request)
    {
      return redirect('diagnosis');

      //------ get inputs-----------------
      $diagnosisForm = $request->except(['_token','firstname','lastname']);

      $patient = Patient::where('hn',$diagnosisForm['hn'])->first();
      if(count($patient) <= 0)
      {
          return redirect()->back()->withInput()->withErrors(['ไม่มีรายชื่อผู้ป่วยภายในระบบ']);
      }
      $doctor = Doctor::find(5);

      //------ keep data in a new Diagnosis as 'key'=>'value' ------------------
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
        //------ keep data in a new Prescription as 'key'=>'value' ------------------
        $prescription = new Prescription([
          'prescriptionDate' => date('Y-m-d')
        ]);
        $prescription->diagnosis()->associate($diagnosis);
        $prescription->save();

        $numDrug = (count($diagnosisForm) - 3)/3;

        for($i = 1; $i <= $numDrug; $i++)
        {
          //------ keep data in a new Drug as 'key'=>'value' ------------------
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
