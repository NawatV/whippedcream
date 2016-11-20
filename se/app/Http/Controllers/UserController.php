<?php

namespace App\Http\Controllers;


use App\Model\Appointment;
use App\Model\Diagnosis;
use App\Model\Doctor;
use App\Model\Patient;
use App\Model\Prescription;
use App\Model\User;
use Illuminate\Http\Request;


class UserController extends Controller
{

	public function seePatientInformation()
    {

          return view('seePatientInformation');
       }

      public function getSearchPatientInformation()
    {
//        $patients = Patient::all();
        $patients = array();
        return view('searchPatientInformation', compact('patients'));

    }

    public function findPatientFromHnIdName(Request $request)
    {
//        $patients = array();
//        $patients = Patient::all();
    	//return dd($request->input('hnNumber'));

        $patients_hn = Patient::where('hn', $request->input('hnNumber'))->value('patientId');
        $patients = User::where('userId', $patients_hn)->first();
        if ($patients == '') {

            $patients = User::where('idNumber', $request->input('idNumber'))->first();

            if ($patients == '') {


                $patients = User::where('firstname', $request->input('firstname'))->where('lastname', $request->input('lastname'))->first();

                if ($patients == '') {
                    $patients = array();
                    return view('seePatientInformation', compact('patients'));
                }
            }

            $patients_hn = Patient::where('patientId', $patients->userId)->value('patientId');
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

        return view('seePatientInformation', compact('patients', 'appointments', 'diagnoses', 'doctors'));
    }
}
