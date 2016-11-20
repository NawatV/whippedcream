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

		public function getEditPatientInformation()
	{

			return view('editPatientInformation');

	}

public function searchPatientFromHnIdNameForEditProfile(Request $request)
{
//        $patients = array();
//        $patients = Patient::all();

		$patients_hn = $request->input('userId');

		$patients = User::where('userId', $patients_hn)->first();


		// $appointments = Appointment::where('patientId', $patients_hn)->get();
		// $diagnoses = Diagnosis::where('patientId', $patients_hn)->get();
		//
		// $doctors = array();
		// foreach ($diagnoses as $diagnosis) {
		// 		$doctorFromDiag = User::where('userId', $diagnosis->doctorId)->first();
		// 		array_push($doctors, $doctorFromDiag);
		// }

//        $diagnoses = array();

//        $prescription = Prescription::where('patientId', $patients_hn)->get();

//        $name = $patients[0]->firstname;

//        dd($name);

 

		return view('editPatientInformation', compact('patients'));
}

    public function findPatientFromHnIdName(Request $request)
    {
//        $patients = array();
//        $patients = Patient::all();


        $patients_hn = Patient::where('hn', $request->input('hnNumber'))->value('patientId');

        $patients = User::where('userId', $patients_hn)->first();
        if ($patients == '') {

            $patients = User::where('idNumber', $request->input('idNumber'))->first();

            if ($patients == '') {


                $patients = User::where('firstname', $request->input('firstname'))->where('lastname', $request->input('lastname'))->first();

                if ($patients == '') {
                    $patients = array();
                    return view('searchPatientInformation', compact('patients'));
                }
            }

            $patients_hn = Patient::where('patientId', $patients->userId)->value('patientId');
        }

        // $appointments = Appointment::where('patientId', $patients_hn)->get();
        // $diagnoses = Diagnosis::where('patientId', $patients_hn)->get();
				//
        // $doctors = array();
        // foreach ($diagnoses as $diagnosis) {
        //     $doctorFromDiag = User::where('userId', $diagnosis->doctorId)->first();
        //     array_push($doctors, $doctorFromDiag);
        // }
//        $diagnoses = array();

//        $prescription = Prescription::where('patientId', $patients_hn)->get();

//        $name = $patients[0]->firstname;

//        dd($name);

        return view('seePatientInformation', compact('patients'));
    }
		public function editPatientInformation(Request $request)
		{
//        dd($diagnosis);
//        return $diagnosis;

			$users = User::where('userId', $request->userId)->first();
			$patients = Patient::where('patientId', $request->userId)->first();
			$users->firstname = $request->newFirstname;
			$users->lastname = $request->newLastname;
			$users->gender = $request->newGender;
			$users->idNumber = $request->newIdNumber;
			$users->birthDate = $request->newBirthDate;
			$users->address = $request->newAddress;
			$users->phoneNumber = $request->newPhoneNumber;
			$users->email = $request->newEmail;
			$patients->bloodType = $request->newBloodType;
			$patients->allergen = $request->newAllergen;

			$users->save();
			$patients->save();
			$patients_hn = $request->input('userId');

			$patients = User::where('userId', $patients_hn)->first();

				return view('seePatientInformation', compact('patients','users'));
		}
}
