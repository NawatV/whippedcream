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
        $scheduleArray = array();
        array_push($scheduleArray, $schedules->sunPeriod);
        array_push($scheduleArray, $schedules->monPeriod);
        array_push($scheduleArray, $schedules->tuePeriod);
        array_push($scheduleArray, $schedules->wedPeriod);
        array_push($scheduleArray, $schedules->thuPeriod);
        array_push($scheduleArray, $schedules->friPeriod);
        array_push($scheduleArray, $schedules->satPeriod);
        return $scheduleArray;
    }
}
