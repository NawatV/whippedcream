<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;

use App\Model\LoginData;
use App\Model\User;
use App\Model\Patient;
use App\Model\Nurse;
use App\Model\Doctor;
use App\Model\Pharmacist;
use App\Model\Staff;
use App\Model\Admin;

use UxWeb\SweetAlert\SweetAlert;
//use Alert;

class LoginController extends Controller
{
    //------------- login -------------------------------------------
    public function getLoginForm()
    {

        return view('login');
    }

    public function postLoginForm(Request $request)
    {
        //------ get inputs-----------------
        $username = $request->input('username');
        $password = $request->input('password');

        //query in DBs
        $user = User::where([['username', '=', $username], ['password', '=', $password]])->first();
        //$user = User::where('username',$username)->first();



        if (count($user) <= 0) {

            return redirect()->back()->withInput()->withErrors(['']);
            //these methods belongs to Laravel (go to the page with error msg)
        }

        //******** belongs to relationship *********
        //*1. identiy that this means "nurse whose id=4"
        //-



        //------ keep data in a new VitalSignData as 'key'=>'$value' --------------
        $userData = new UserData([
            'username' => $username,
            'password' => $password,
        ]);
        //*2. $vitalSignData belongs to $patient
        $userData->user()->associate($user);
        //*3. save $vitalSignData
        $user->save();

        return redirect('login');
    }
}
