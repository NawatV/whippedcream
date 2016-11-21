<?php

namespace App\Http\Controllers;


use App\Model\Appointment;
use App\Model\Diagnosis;
use App\Model\Doctor;
use App\Model\Patient;
use App\Model\Prescription;
use App\Model\User;
use App\Http\Requests\PatientProfileRequest;
use Illuminate\Http\Request;


class UserController extends Controller
{
//ของผู้ป่วย


		//
		// public function login_temp(Request $request)
		//     {
		//       $request->session()->put([
		//         'userId' => 6,
		//         'userType' => 'patient',
		//         'name' => 'patient1Nameshhhssstest'
		//       ]);
		//       return view('welcome');
		//     }


public function myPatientInformation(Request $request)
	{

		$patients_hn = $request->session()->get('userId');
		$patients = User::where('userId', $patients_hn)->first();
		$patients2 = Patient::where('patientId', $patients_hn)->first(); // patients2 Patient query
				return view('myPatientInformation' , compact('patients','patients2'));
			}


		 public function editMyPatientInformation(Request $request)
		 	{
				$patients_hn = $request->session()->get('userId');
		 		$patients = User::where('userId', $patients_hn)->first();
		 		$patients2 = Patient::where('patientId', $patients_hn)->first(); // patients2 Patient query

		 				return view('myEditedPatientInformation', compact('patients','patients2'));

		 		 }

public function seeEditedMyPatientInformation(Request $request)
		{

			$patients_hn = $request->input('userId');
			$patients = User::where('userId', $patients_hn)->first();
			$patients2 = Patient::where('patientId', $patients_hn)->first();
			$patients->firstname = $request->firstname;
			$patients->lastname = $request->lastname;
			$patients->gender = $request->gender;
			$patients->idNumber = $request->idNumber;
			$patients->birthDate = $request->birthDate;
			$patients->address = $request->address;
			$patients->phoneNumber = $request->phoneNumber;
			$patients->email = $request->email;
			$patients2->bloodType = $request->bloodType;
			$patients2->allergen = $request->allergen;

			$patients->save();
			$patients2->save();



				return view('myPatientInformation', compact('patients','patients2'));

		}











// ของไม่ใช่ผู้ป่วย
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
		$patients2 = Patient::where('patientId', $patients_hn)->first(); // patients2 Patient query

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



		return view('editPatientInformation', compact('patients','patients2'));
}

    public function findPatientFromHnIdName(Request $request)
    {
//        $patients = array();
//        $patients = Patient::all();


        $patients_hn = Patient::where('hn', $request->input('hnNumber'))->value('patientId');

        $patients = User::where('userId', $patients_hn)->first(); // patients User query
				$patients2 = Patient::where('patientId', $patients_hn)->first(); // patients2 Patient query

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

        return view('seePatientInformation', compact('patients','patients2'));
    }


		//PatientProfileRequest $request cannot use
		public function editPatientInformation(PatientProfileRequest $request)
		{
//        dd($diagnosis);
//        return $diagnosis;
		  $patients_hn = $request->input('userId');
			$patients = User::where('userId', $patients_hn)->first();
			$patients2 = Patient::where('patientId', $patients_hn)->first();
			$patients->firstname = $request->firstname;
			$patients->lastname = $request->lastname;
			$patients->gender = $request->gender;
			$patients->idNumber = $request->idNumber;
			$patients->birthDate = $request->birthDate;
			$patients->address = $request->address;
			$patients->phoneNumber = $request->phoneNumber;
			$patients->email = $request->email;
			$patients2->bloodType = $request->bloodType;
			$patients2->allergen = $request->allergen;

			$patients->save();
			$patients2->save();



				return view('seePatientInformation', compact('patients','patients2'));
		}
}
