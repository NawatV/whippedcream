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

class ScheduleControllerStaff extends Controller
{
    //---------viewScheduleStaffDefault------------
    public function viewScheduleStaffDefault(Request $request)
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
                return view('schedulestaff', compact('pack'));   //MUST USE THIS
                //return view('schedule')->with($pack);
                //return View::make('schedule')->with($pack);
        }
        else { 
            return redirect('login');
        }        
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

                return view('schedulestaff', compact('pack'));   //MUST USE THIS
                //return view('schedule')->with($pack);
                //return View::make('schedule')->with($pack);
            }
            else {
                return redirect('schedulestaff');
            }
                
        }
        else { 
            return redirect('login');
        }        
        
    }
}
