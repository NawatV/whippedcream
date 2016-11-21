<?php

//Flow: No.2-Controller

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Department;
use App\Model\User;
use App\Model\Doctor;
use App\Model\Staff;
use App\Model\Schedule;
use App\Model\Leaving;			
//Link to Model->"Schedule.php": You can see the relationships here.

class ScheduleController extends Controller
{
    //----viewSchedule-----
    public function viewSchedule(Request $request)
    {
        //return dd($request->session()->get('userId'));  //#### FOR CHECKING VALUE:
        
        //--------for doctor----------
        $userId = $request->session()->get('userId'); 
        //query (haven't check unique yet)
        $doctor = Doctor::where('doctorId',$userId)->first(); //doctorNumber ?
        $staff = Staff::where('staffId',$userId)->first(); //staffNumber ?
         
        if(count($doctor)==1) {

                $sche = Schedule::where('doctorId',$userId)->first();
                $abs = Leaving::where('doctorId', $userId)->get(); //get all rows in this condition in $ads (array) 

                $pack = array(
                    'sche' => $sche,
                    'abs' => $abs
                );

                return view('schedule', compact('pack'));   //MUST USE THIS
                //return view('schedule')->with($pack);
                //return View::make('schedule')->with($pack);
        }
        else if(count($staff)==1){
                 $pack = array();
                return view('schedule', compact('pack'));   //MUST USE THIS
        }
        else { 
            return redirect('login');
        }        
        
        //----for staff----
            //show in desktop?

        //return view('schedule');
    }

    public function addAbsent(Request $request)
    {
        //return dd($request);

        //------ get inputs-----------------
        $leavingId = rand(0,9999999);   //FIX LATER

        $userId = $request->session()->get('userId');

        $absentdate = $request->input('absentdate');
        $tmp = strtotime($absentdate);
        $leaveDate = date('Y-m-d',$tmp);  

        $absentperiod = $request->input('absentperiod');

        //return dd($absentperiod);

        //------- query in DBs : https://laravel.com/docs/5.3/queries#deletes --------
        //$newabs = Leaving::insert('insert into leaving (leavingId, doctorId, leaveDate, leavePeriod) values(4, $userId, $absentdate, $absentperiod)');    
        //leavingId ?

         $theabsent = new Leaving([

            'leavingId' => $leavingId, // $absentdate
            'doctorId' => $userId,
            'leaveDate' => $leaveDate, 
            'leavePeriod' => $absentperiod
        ]);
      
        //$theabsent->patient()->associate($patient);
        //$vitalSignData->nurse()->associate($nurse);
        $theabsent->save();

        //return dd($theabsent);  PROBLEAM AT LEAVING ID

        return redirect('schedule');
    }


     //----viewScheduleStaff-----
    public function viewScheduleStaff(Request $request)
    {
        //return dd($request->session()->get('userId'));  //#### FOR CHECKING VALUE:

        //--------for doctor----------
        $userId = $request->session()->get('userId'); 
        //query (haven't check unique yet)
        $staff = Staff::where('staffId',$userId)->first();
         
        if(count($staff)==1) {

                $searchId = $request->input('searchId');

                $sche = Schedule::where('doctorId',$searchId)->first();
                $abs = Leaving::where('doctorId', $searchId)->get(); //get all rows in this condition in $ads (array) 

            $pack = array();

            if(count($sche)>0 || count($abs)>0 ){
                $pack = array(
                    'sche' => $sche,
                    'abs' => $abs
                );
            }
                return view('schedule', compact('pack'));   //MUST USE THIS
                //return view('schedule')->with($pack);
                //return View::make('schedule')->with($pack);
        }
        else { 
            return redirect('login');
        }        
        
        //----for staff----
            //show in desktop?

        //return view('schedule');
    }

}
