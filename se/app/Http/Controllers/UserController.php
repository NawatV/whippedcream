<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Model\User;


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

        //query in DBs
        $user = User::where([['username', '=', $username], ['password', '=', $password]])->first();

        if (count($user) <= 0) {
            return redirect()->back()->withInput()->withErrors(['']);
            //these methods belongs to Laravel (go to the page with error msg)
        }

        $request->session()->put([
            'userId' => $user->userId,
            'userType' => $user->userType,
            'name' => $user->firstname
        ]);

        return redirect('schedule');
    }

    public function postRegisterForm(RegisterRequest $request)
    {
        dd($request);

        //------ get inputs-----------------
        $userId = $request->input('userId');
        $username = $request->input('username');
        $password = $request->input('password');
        $idNumber = $request->input('idNumber');
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $gender = $request->input('gender');
        $birthDate = $request->input('birthDate');
        $phoneNumber = $request->input('phoneNumber');
        $email = $request->input('email');
        $address = $request->input('address');
        $bloodType = $request->input('bloodType');
        $userType = "patient"; //Only Patient

        $user = User::where('username',$username)->first(); //query in DB
        if(count($user) > 0)
        {
            return redirect()->back()->withInput()->withErrors(['ชื่อบัญชีผู้ใช้นี้มีอยู๋ในระบบแล้ว กรุณาลองเปลี่ยนเป็นชื่ออื่น ']);
            //these methods belongs to Laravel (go to the page with error msg)
        }

        //******** belongs to relationship *********
        //------ keep data in a new RegisterData as 'key'=>'$value' --------------
        $registerData = new RegisterData([

            'userId' => $userId ,
            'username' => $username,
            'password' => $password,
            'idNumber' => $idNumber,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'gender' => $gender,
            'birthDate' => date('Y-m-d'),
            'phoneNumber' => $phoneNumber,
            'email' => $email,
            'address' => $address,
            'userType' => $userType  //Only Patient

        ]);
        //*2. $RegisterData belongs to Only $patient
        $registerData->patient()->associate($patient);

        //*3. save $RegisterData
        $registerData->save();


//        save ค่า Regis

        //ทำคำสั่ง login

        // redirect to Home

        return redirect('register');
    }



}
