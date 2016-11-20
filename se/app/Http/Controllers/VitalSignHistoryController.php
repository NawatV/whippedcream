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



class vitalSignHistoryController extends Controller
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

    public function editVitalSignHistoryForm(VitalSign $diagnosis)
    {
//        dd($diagnosis);
//        return $diagnosis;
        return view('editVitalSignHistoryForm', compact('vitalsign'));
    }

    public function confirm(Request $request)
    {
        $diagnosis = Diagnosis::where('diagnosisId', $request->diagnosisId)->first();
        $diagnosis->symptomcode = $request->newSymptomcode;
        $diagnosis->diagnosisDetail = $request->newDiagnosisDetail;
        $diagnosis->save();
        return back();
//        http://localhost/editDiagnosisHistory
//        return redirect()->route('login');
    }

    public function delete($diagnosisId)
    {
        $diag = Diagnosis::where('diagnosisId', $diagnosisId);
        return dd($diag);
        // return $diag;
        $diag->delete();
        return back();
    }

    public function findPatientFromHnIdNameForVitalSign(Request $request)
    {
//        $patients = array();
//        $patients = Patient::all();



        $patients_hn = $request->input('userId');

        $patients = User::where('userId', $patients_hn)->first();


        $appointments = Appointment::where('patientId', $patients_hn)->get();
        $vitalsigns = VitalSignData::where('patientId', $patients_hn)->get();

        $nurses = array();
        foreach ($vitalsigns as $vitalsign) {
            $nurseFromVital = User::where('userId', $vitalsign->nurseId)->first();
            array_push($nurses, $nurseFromVital);
        }

//        $diagnoses = array();

//        $prescription = Prescription::where('patientId', $patients_hn)->get();

//        $name = $patients[0]->firstname;

//        dd($name);


        return view('editvitalSignHistoryFoundPatient', compact('patients', 'appointments', '$vitalsigns', 'nurses'));
    }


    //    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========



}
