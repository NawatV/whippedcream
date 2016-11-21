<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Model\Patient;
use Illuminate\Http\Request;
use App\Model\User;
use Illuminate\Support\Facades\Hash;


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

            if ($user->userType === 'nurse' or $user->userType === 'pharmacist' or $user->userType === 'staff' or $user->userType === 'doctor' or $user->userType === 'patient'){
                return redirect('homepage')->with('status', 'เข้าสู่ระบบ สำเร็จ');

            }elseif ($user->userType === 'admin'){
                return redirect('manageAccount')->with('status', 'เข้าสู่ระบบ สำเร็จ');
            }

            return redirect()->back()->with('e', 'มีบางอย่างผิดพลาด');
        }

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

}

