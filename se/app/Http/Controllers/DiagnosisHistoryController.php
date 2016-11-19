<?php

namespace App\Http\Controllers;

use App\Model\Appointment;
use App\Model\Diagnosis;
use App\Model\Doctor;
use App\Model\Patient;
use App\Model\Prescription;
use App\Model\User;
use Illuminate\Http\Request;

class DiagnosisHistoryController extends Controller
{
    //
    public function editDiagnosisHistory()
    {
//        $patients = Patient::all();
        $patients = array();
        return view('editDiagnosisHistory', compact('patients'));
    }

    public function viewDiagnosisHistory()
    {
        return view('viewDiagnosisHistory');
    }

    public function editDiagnosisHistoryForm(Diagnosis $diagnosis)
    {
        dd($diagnosis);
        echo $diagnosis;
        return view('editDiagnosisHistoryForm', compact($diagnosis));
    }

    public function confirm()
    {
        echo 'confirm';
    }

    public function findPatientFromHnIdName(Request $request)
    {
//        $patients = array();
//        $patients = Patient::all();

        $patients_hn = Patient::where('hn', $request->input('hnNumber'))->value('patientId');
        $patients = User::where('userId', $patients_hn)->first();

//        dd($patients);
//        if($patients->isEmpty()){
        if ($patients == '') {
            $patients = array();
            return view('editDiagnosisHistory', compact('patients'));
        }
        $appointments = Appointment::where('patientId', $patients_hn)->get();
        $diagnoses = Diagnosis::where('patientId', $patients_hn)->get();

        $doctors = array();
        foreach ($diagnoses as $diagnosis) {
            $doctorFromDiag = User::where('userId', $diagnosis->doctorId)->first();
            array_push($doctors, $doctorFromDiag);
        }

//        $diagnoses = array();

//        $prescription = Prescription::where('patientId', $patients_hn)->get();

//        $name = $patients[0]->firstname;

//        dd($name);


        return view('editDiagnosisHistoryFoundPatient', compact('patients', 'appointments', 'diagnoses', 'doctors'));
    }

}
