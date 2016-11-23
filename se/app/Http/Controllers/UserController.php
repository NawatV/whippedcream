<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;

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
    //
    public function loginForm()
    {
        return view('login');
    }

    public function registerForm()
    {
        return view('register');
    }

    public function postLoginForm(Request $request)
    {
        //------ get inputs-----------------
        $username = $request->input('username');
        $password = $request->input('password');

        if ($request->input('username') == '' or $request->input('password') == '') {
            return redirect()->back()->withInput()->withErrors(['']);
        }


        //query in DBs
        $user = User::where('username', $username)->first();
        if ($user == '') {
            return redirect()->back()->withInput()->withErrors(['']);
        }


        if (Hash::check($password, $user->password)) {
            $request->session()->put([
                'userId' => $user->userId,
                'userType' => $user->userType,
                'name' => $user->firstname
            ]);
//-----------------------------------------------------------------------------
            if ($user->userType === 'nurse' or $user->userType === 'pharmacist' or $user->userType === 'staff' or $user->userType === 'doctor' or $user->userType === 'patient') {
                return redirect('homepage')->with('status', 'เข้าสู่ระบบ สำเร็จ');

            } elseif ($user->userType === 'admin') {
                return redirect('manageAccount')->with('status', 'เข้าสู่ระบบ สำเร็จ');
            }

            return redirect()->back()->with('e', 'มีบางอย่างผิดพลาด');
        }
//----------------------------------------------------------------------------
        return redirect()->back()->withInput()->withErrors(['']);

    }


    public function postRegisterForm(RegisterRequest $request)
    {

//        Process:
//        1. Register
//        2. Login
//        3. Redirect

        //------ get inputs-----------------

        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $idNumber = $request->input('idNumber');
        $birthDate = $request->input('birthDate');
        $phoneNumber = $request->input('phoneNumber');
        $email = $request->input('email');
        $address = $request->input('address');
        $gender = $request->input('gender');
        $bloodType = $request->input('bloodType');
        $username = $request->input('username');
        $password = $request->input('password');
        $allergen = $request->input('allergen');

        $userType = "patient"; //Only Patient

        $user = User::where('username', $username)->first(); //query in DB
        if (count($user) > 0) {
            return redirect()->back()->withInput()->withErrors(['ชื่อบัญชีผู้ใช้นี้มีอยู๋ในระบบแล้ว กรุณาลองเปลี่ยนเป็นชื่ออื่น ']);
            //these methods belongs to Laravel (go to the page with error msg)
        }

        $newUser = new User();
        //not include 'userId' since it's auto-increment
        $newUser->username = $username;

        $newUser->idNumber = $idNumber;
        $newUser->firstname = $firstname;
        $newUser->lastname = $lastname;
        $newUser->gender = $gender;

        $newUser->birthDate = date("Y-m-d", strtotime($birthDate));

        $newUser->phoneNumber = $phoneNumber;
        $newUser->email = $email;
        $newUser->address = $address;
        $newUser->userType = $userType;

        $encryptedPassword = bcrypt($password);
        $newUser->password = $encryptedPassword;

        $newUser->save();

//    patientId bloodType allergen hn
        $newUserId = User::where('idNumber', $idNumber)->value('userId');

        $newPatient = new Patient();
        $newPatient->bloodType = $bloodType;
        $newPatient->patientId = $newUserId;
        $newPatient->allergen = $allergen;

        $hn = str_pad($newUserId, 13, '0', STR_PAD_LEFT);
        $newPatient->hn = $hn;

        $newPatient->save();

        $user = User::where('idNumber', $idNumber)->first();
        $request->session()->put([
            'userId' => $user->userId,
            'userType' => $user->userType,
            'name' => $user->firstname
        ]);

        return redirect('homepage')->with('status', 'ลงทะเบียน สำเร็จ');
    }


    public function myPatientInformation(Request $request)
    {
        $patients_hn = $request->session()->get('userId');
        $patients = User::where('userId', $patients_hn)->first();
        $patients2 = Patient::where('patientId', $patients_hn)->first(); // patients2 Patient query
        return view('myPatientInformation', compact('patients', 'patients2'));
    }

    public function editMyPatientInformation(Request $request)
    {
        $patients_hn = $request->session()->get('userId');
        $patients = User::where('userId', $patients_hn)->first();
        $patients2 = Patient::where('patientId', $patients_hn)->first(); // patients2 Patient query
        return view('myEditedPatientInformation', compact('patients', 'patients2'));
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

        return view('myPatientInformation', compact('patients', 'patients2'));
    }

    // ของไม่ใช่ผู้ป่วย
    public function seePatientInformation()
    {
        return view('seePatientInformation');
    }


    public function getSearchPatientInformation()
    {
        $patients = array();
        return view('searchPatientInformation', compact('patients'));
    }

    public function getEditPatientInformation()
    {
        return view('editPatientInformation');
    }

    public function searchPatientFromHnIdNameForEditProfile(Request $request)
    {
        $patients_hn = $request->input('userId');
        $patients = User::where('userId', $patients_hn)->first();
        $patients2 = Patient::where('patientId', $patients_hn)->first(); // patients2 Patient query
        return view('editPatientInformation', compact('patients', 'patients2'));
    }

    public function findPatientFromHnIdName(Request $request)
    {
        $patients_hn = Patient::where('hn', $request->input('hnNumber'))->value('patientId');
        $patients = User::where('userId', $patients_hn)->first(); // patients User query
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
        $patients2 = Patient::where('patientId', $patients_hn)->first(); // patients2 Patient query
        return view('seePatientInformation', compact('patients', 'patients2'));
    }


    //PatientProfileRequest $request cannot use
    public function editPatientInformation(PatientProfileRequest $request)
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

        return view('seePatientInformation', compact('patients', 'patients2'));
    }


}