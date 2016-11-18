<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Appointment;
use App\Model\Doctor;
use App\Model\Patient;
use App\Model\User;
use App\Model\Department;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointment = Appointment::all();
        return view('appointment.index',[
            'appointments' => $appointment
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = Department::all();
        return view('appointment.create',[
            'departments' => $department
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        //return dd($request->all());
        $appointment = new Appointment();
        $appointment -> appDate = date("2016-11-19");
        $appointment -> appTime = date('H:m:s', time())  ;
        $appointment -> symptom = $request -> symptom;
        $appointment -> patientId = "4";//wait for user login
        if ($request -> doctorId == "0") {
            $department = Department::find($request -> departmentId);
            $appointment -> doctorId = $department -> doctor[0] -> doctorId; 
        } else {
            $appointment -> doctorId = $request -> doctorId;
        }
        $appointment -> save();
        return redirect() -> action('AppointmentController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $appointment = Appointment::find($id);
        return view('appointment.edit', [
            'appointment' => $appointment
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function queryDoctor(Request $request)
    {
        $alldoctor = Doctor::where('departmentId', '=', $request->id)->get();
        $doctors = array();
        foreach ($alldoctor as $doctor) {
            $doctorTmp = Doctor::find($doctor->doctorId);
            $tmp = array($doctorTmp->doctorId, $doctorTmp->user->firstname, $doctorTmp->user->lastname);
            array_push($doctors, $tmp);
        }
        return $doctors;
    }

    public function queryDoctorDateTime(Request $request)
    {
        $doctor = Doctor::find($request->id);
        $schedules = $doctor -> schedule;
        $fastestDate = "no";
         
        for ($x = 1; $x < 7; $x++) {
            if(date('l', strtotime($x.' days', strtotime('today'))) == "Sunday" && $schedules->sunPeriod != "0" ){
                $fastestDate = date("Y-m-d", strtotime('Sunday'));
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Monday" && $schedules->monPeriod != 0){
                $fastestDate = date("Y-m-d", strtotime('Monday'));
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Tuesday" && $schedules->tuePeriod != 0){
                $fastestDate = date("Y-m-d", strtotime('Tuesday'));
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Wednesday" && $schedules->wedPeriod != 0){
                $fastestDate = date("Y-m-d", strtotime('Wednesday'));
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Thursday" && $schedules->thuPeriod != 0){
                $fastestDate = date("Y-m-d", strtotime('Thursday'));
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Friday" && $schedules->friPeriod != 0){
                $fastestDate = date("Y-m-d", strtotime('Friday'));
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Saturday" && $schedules->satPeriod != 0){
                $fastestDate = date("Y-m-d", strtotime('Saturday'));
                break;
            }

        } 
          

        $scheduleArray = array
        (
            array("sunPeriod", $schedules->sunPeriod),
            array("monPeriod", $schedules->monPeriod),
            array("tuePeriod", $schedules->tuePeriod),
            array("wedPeriod", $schedules->wedPeriod),
            array("thuPeriod", $schedules->thuPeriod),
            array("friPeriod", $schedules->friPeriod),
            array("satPeriod", $schedules->satPeriod),
            array("fastestDate", $fastestDate)
        );
        return $scheduleArray;
    }
}
