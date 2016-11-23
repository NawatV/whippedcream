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
use App\Model\Petition;


class TreatmentController extends Controller
{


    public function login_temp(Request $request)

    {
        $request->session()->put([
            'userId' => 4,
            'userType' => 'pharmacist',
            'name' => 'เภสัชกรคนหนึ่ง'
        ]);
        return view('welcome');
    }


//------------- vialSign -------------------------------------------

    public function getVitalSignForm(Request $request)
    {
        return view('vitalsign')->with('name', $request->session()->get('name'));
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

        $patient = Patient::where('hn', $hn)->first(); //query in DB
        if (count($patient) <= 0) {
            return redirect()->back()->withInput()->withErrors(['ไม่มีรายชื่อผู้ป่วยภายในระบบ']);
        }

        $nurse = Nurse::find($request->session()->get('userId'));

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

        $vitalSignData->patient()->associate($patient);
        $vitalSignData->nurse()->associate($nurse);
        $vitalSignData->save();

        return redirect('vitalsign');
    }

    //------------- diagnosisForm -------------------------------------------

    public function getDiagnosisForm(Request $request)
    {
        return view('diagnosis')->with('name', $request->session()->get('name'));
    }

    public function saveDiagnosisForm(DiagnosisRequest $request)
    {
        $diagnosisForm = $request->except(['_token', 'firstname', 'lastname']);

        $patient = Patient::where('hn', $diagnosisForm['hn'])->first();

        if (count($patient) <= 0) {
            return redirect()->back()->withInput()->withErrors(['ไม่มีรายชื่อผู้ป่วยภายในระบบ']);
        } else if (count($diagnosisForm) > 3) {
            $num = (count($diagnosisForm) - 3) / 3;

            for ($i = 1; $i <= $num; $i++) {
                if (empty($diagnosisForm['quantity' . $i]) && empty($diagnosisForm['usage' . $i])) {
                    return redirect()->back()->withInput()->withErrors(['โปรดระบุปริมาณและวิธีใช้ยา ' . $diagnosisForm['drug' . $i]]);
                } else if (empty($diagnosisForm['quantity' . $i])) {
                    return redirect()->back()->withInput()->withErrors(['โปรดระบุปริมาณยา ' . $diagnosisForm['drug' . $i]]);
                } else if (!is_numeric($diagnosisForm['quantity' . $i])) {
                    return redirect()->back()->withInput()->withErrors(['โปรดระบุปริมาณยา ' . $diagnosisForm['drug' . $i] . ' เป็นตัวเลข']);
                } else if (empty($diagnosisForm['usage' . $i])) {
                    return redirect()->back()->withInput()->withErrors(['โปรดระบุวิธีใช้ยา ' . $diagnosisForm['drug' . $i]]);
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

        if (count($diagnosisForm) > 3) {
            $prescription = new Prescription([
                'prescriptionDate' => date('Y-m-d')
            ]);
            $prescription->diagnosis()->associate($diagnosis);
            $prescription->save();

            $numDrug = (count($diagnosisForm) - 3) / 3;

            for ($i = 1; $i <= $numDrug; $i++) {
                $drug = new Drug([
                    'drugName' => $diagnosisForm['drug' . $i],
                    'drugUsage' => $diagnosisForm['usage' . $i],
                    'drugAmount' => $diagnosisForm['quantity' . $i]
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

        foreach ($prescriptions as $prescription) {
            $prescriptionId = $prescription->prescriptionId;
            $approved = $prescription->isApproved;
            $firstname = $prescription->diagnosis->patient->user->firstname;
            $lastname = $prescription->diagnosis->patient->user->lastname;
            $patient_name = $firstname . " " . $lastname;

            $data = [
                'index' => $prescriptionId,
                'status' => $approved,
                'name' => $patient_name
            ];

            if (is_null($approved)) array_push($dispense_list_wait, $data);
            else array_push($dispense_list_other, $data);
        }

        $dispense_list = array_merge($dispense_list_wait, $dispense_list_other);

        return view('dispensation', compact('dispense_list'))->with('name', $request->session()->get('name'));
    }

    public function getPrescription($id)
    {
        $prescription = Prescription::find($id);

        if (count($prescription) <= 0 || count($prescription) > 1) {
            return "failed";
        }

        $drugs = $prescription->drug;

        return compact('drugs');
    }

    public function confirmPrescription(Request $request, $id)
    {
        $prescription = Prescription::find($id);
        if (count($prescription) <= 0 || count($prescription) > 1) {
            return "failed";
        }

        $pharmacistId = $request->session()->get('userId');

        $prescription->isApproved = true;
        $prescription->pharmacist()->associate($pharmacistId);
        $prescription->save();

        return "success";
    }

    public function editPrescription(Request $request)
    {
        $prescriptionId = $request->input('prescriptionId');
        $detail = $request->input('edit-detail');

        $prescription = Prescription::find($prescriptionId);

        if (count($prescription) <= 0 || $detail == "") {
            return redirect()->back();
        }

        $pharmacistId = $request->session()->get('userId');

        $prescription->isApproved = false;
        $prescription->pharmacist()->associate($pharmacistId);
        $prescription->save();

        $doctorId = $prescription->diagnosis->doctorId;

        $petition = new Petition([
            'pharmacistId' => $pharmacistId,
            'doctorId' => $doctorId,
            'isReaded' => false,
            'petitionDate' => date('Y-m-d'),
            'prtitionNote' => $detail
        ]);
        $petition->save();

        return redirect('dispensation');
    }

    public function getNumberPrescription(Request $request)
    {
        // return $request->fullUrl();
        $num = $request->input('num');
        $number = Prescription::where('prescriptionDate', date('Y-m-d'))->count();

        if ($number <= $num) return "success";

        $old_list = explode(",", $request->input('list'));

        $lists = Prescription::whereNull('isApproved')->where('prescriptionDate', date('Y-m-d'))->whereNotIn('prescriptionId', $old_list)->get();

        $result = [];

        foreach ($lists as $list) {
            $data['index'] = $list->prescriptionId;
            $firstname = $list->diagnosis->patient->user->firstname;
            $lastname = $list->diagnosis->patient->user->lastname;
            $data['name'] = $firstname . ' ' . $lastname;

            array_push($result, $data);
        }

        return $result;
    }

}
