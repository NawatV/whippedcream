<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\RegisterRequest;

use App\Model\RegisterData;
use App\Model\User;
use App\Model\Patient;
use App\Model\Nurse;
use App\Model\Doctor;
use App\Model\Pharmacist;
use App\Model\Staff;
use App\Model\Admin;

class RegisterController extends Controller
{
  //------------- login -------------------------------------------
    public function getRegisterForm()
    {

      return view('regis');
    }

    public function postRegisterForm(RegisterRequest $request)
    {
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

      return redirect('regis');
    }
}
