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


    public function login_temp(Request $request)
    {
      $request->session()->put([
        'userId' => 3,
        'userType' => 'doctor',
        'name' => 'นายแพทย์คนหนึ่ง'
      ]);
      return view('welcome');
    }


    public function getVitalSignForm(Request $request)
    {
      return view('vitalsign')->with('name', $request->session()->get('name'));
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

      $nurse = Nurse::find($request->session()->get('userId'));

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

    public function getDiagnosisForm(Request $request)
    {
      return view('diagnosis')->with('name', $request->session()->get('name'));
    }

    public function saveDiagnosisForm(DiagnosisRequest $request)
    {
      $diagnosisForm = $request->except(['_token','firstname','lastname']);

      $patient = Patient::where('hn',$diagnosisForm['hn'])->first();

      if(count($patient) <= 0)
      {
          return redirect()->back()->withInput()->withErrors(['ไม่มีรายชื่อผู้ป่วยภายในระบบ']);
      }
      else if(count($diagnosisForm) > 3)
      {
        $num = (count($diagnosisForm) - 3)/3;

        for($i = 1; $i <= $num; $i++)
        {
          if(empty($diagnosisForm['quantity'.$i]) && empty($diagnosisForm['usage'.$i]))
          {
            return redirect()->back()->withInput()->withErrors(['โปรดระบุปริมาณและวิธีใช้ยา '.$diagnosisForm['drug'.$i]]);
          }
          else if(empty($diagnosisForm['quantity'.$i]))
          {
            return redirect()->back()->withInput()->withErrors(['โปรดระบุปริมาณยา '.$diagnosisForm['drug'.$i]]);
          }
          else if(!is_numeric($diagnosisForm['quantity'.$i]))
          {
            return redirect()->back()->withInput()->withErrors(['โปรดระบุปริมาณยา '.$diagnosisForm['drug'.$i].' เป็นตัวเลข']);
          }
          else if(empty($diagnosisForm['usage'.$i]))
          {
            return redirect()->back()->withInput()->withErrors(['โปรดระบุวิธีใช้ยา '.$diagnosisForm['drug'.$i]]);
          }
        }
      }

      $doctor = Doctor::find($request->session()->get('userId'));

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

    public function getDispensationPage(Request $request)
    {
      $prescriptions = Prescription::where('prescriptionDate', date('Y-m-d'))->get();


      $dispense_list_wait = [];
      $dispense_list_other = [];

      foreach($prescriptions as $prescription)
      {
        $prescriptionId = $prescription->prescriptionId;
        $approved = $prescription->isApproved;
        $firstname = $prescription->diagnosis->patient->user->firstname;
        $lastname = $prescription->diagnosis->patient->user->lastname;
        $patient_name = $firstname." ".$lastname;

        $data = [
          'index' => $prescriptionId,
          'status' => $approved,
          'name' => $patient_name
        ];

        if(is_null($approved)) array_push($dispense_list_wait, $data);
        else array_push($dispense_list_other, $data);
      }

      $dispense_list = array_merge($dispense_list_wait, $dispense_list_other);

      return view('dispensation', compact('dispense_list'))->with('name', $request->session()->get('name'));
    }

}
