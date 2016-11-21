<?php

namespace App\Http\Controllers;

use App\Model\Appointment;
use App\Model\Diagnosis;
use App\Model\Doctor;
use App\Model\Patient;
use App\Model\Prescription;
use App\Model\User;
use App\Model\Nurse;
use App\Model\VitalSignData;
use Illuminate\Http\Request;



class VitalSignHistoryController extends Controller
{
//     //
//     public function editVitalSignHistory()
//     {
// //        $patients = Patient::all();
//         $patients = array();
//         return view('editDiagnosisHistory', compact('patients'));
//     }
//
//     public function viewDiagnosisHistory()
//     {
//         return view('viewDiagnosisHistory');
//     }


    public function seeVitalSignHistory(Request $request){

            $vitalID = $request->input('vitalsignID');
            $vitalsigns = VitalSignData::where('vitalSignDataId',$vitalID)->first();
            $patients_hn = $request->input('userId');
            $patients = User::where('userId', $patients_hn)->first();
              $patients2 = Patient::where('patientId', $patients_hn)->first(); // patients2 Patient query
            //  return dd($vitalsigns->all());
      //        return $diagnosis;

              return view('editVitalSignHistoryForm',compact('patients','patients2','vitalsigns'));
    }
    public function seeEditVitalSignHistory(Request $request)
    {

      $vitalID = $request->input('vitalsignID');
      $vitalsigns = VitalSignData::where('vitalSignDataId',$vitalID)->first();
      $patients_hn = $request->input('userId');
      $patients = User::where('userId', $patients_hn)->first();
      	$patients2 = Patient::where('patientId', $patients_hn)->first(); // patients2 Patient query
      //  return dd($vitalsigns->all());
//        return $diagnosis;
        return view('editVitalSignHistoryFormForEdited',compact('patients','patients2','vitalsigns'));
    }
    public function editVitalSignHistory(Request $request)
    {
    //        dd($diagnosis);
    //        return $diagnosis;
    $patients_hn = $request->input('userId');
    $patients = User::where('userId', $patients_hn)->first();
      $patients2 = Patient::where('patientId', $patients_hn)->first(); // patients2 Patient query
    $vitalID = $request->input('vitalsignID');
    $vitalsigns = VitalSignData::where('vitalSignDataId',$vitalID)->first();

    $vitalsigns->height = $request->height;
    $vitalsigns->weight = $request->weight;
    $vitalsigns->temperature = $request->temperature;
    $vitalsigns->pulse = $request->pulse;
    $vitalsigns->systolic = $request->systolic;
    $vitalsigns->diastolic = $request->diastolic;


    $vitalsigns->save();
                return view('editVitalSignHistoryForm',compact('patients','patients2','vitalsigns'));
    }


    public function findPatientFromHnIdNameForVitalSign(Request $request)
    {
//        $patients = array();
//        $patients = Patient::all();


        $patients_hn = $request->input('userId');
        $patients = User::where('userId', $patients_hn)->first();
        	$patients2 = Patient::where('patientId', $patients_hn)->first(); // patients2 Patient query

        $vitalsigns = VitalSignData::where('patientId', $patients_hn)->get();

        return view('editVitalSignHistoryFoundPatient', compact('patients','patients2','vitalsigns'));
    }


    //    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========



}
