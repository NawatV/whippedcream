<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Request;

use App\Model\Appointment;
use App\Model\Doctor;
use App\Model\Patient;
use App\Model\User;
use App\Model\Department;
use DB;
use App\Model\Schedule;
use App\Model\Leaving;
use Barryvdh\DomPDF\Facade as PDF;
use App\Model\Admin;



class OtherController extends Controller
{
    //
    public function blankPage(Request $request){
        return view ('blank', compact('request'));
    }

    public function homepage(Request $request){
        return view('homepage', compact('request'));
    }

    public function testpage(Request $request){
        $department = Department::all();
        return view('appointment.create', [
            'departments' => $department
        ]);
    }

    public function logout(){
        session()->flush();
        return redirect('/');
    }












}
