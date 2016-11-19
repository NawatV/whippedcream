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
    public function index()
    {
        $appointment = Appointment::all();
        return view('appointment.index',[
            'appointments' => $appointment
        ]);
    }

    public function create()
    {
        $department = Department::all();
        return view('appointment.create',[
            'departments' => $department
        ]);
    }

    public function store(Request $request)
    {
        //return dd($request->all());
        $appointment = new Appointment();
        $appointment -> symptom = $request -> symptom;
        if($request -> doctorId == "0"){
            $appointment -> doctorId = Department::find($request -> departmentId)-> doctor[0]-> doctorId;
        }
        else{
            $appointment -> doctorId = $request -> doctorId;
        }
        $appointment -> appDate = $request -> appDate;
        if($request -> appTime == "1"){
            $appointment -> appTime = "9:00";
        }elseif($request -> appTime == "2"){
            $appointment -> appTime = "13:00";
        }

        $appointment -> patientId = "4";//wait for user login
        $appointment -> save();
        return redirect() -> action('AppointmentController@index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $appointment = Appointment::find($id);
        return view('appointment.edit', [
            'appointment' => $appointment
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($appointment)
    {
        Appointment::destroy($appointment);
        return redirect() -> action('AppointmentController@index');
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
        //$doctor = Doctor::all()[0];
        if($request->id == "0"){
            $department = Department::find($request -> departmentId);
            $doctor = $department -> doctor[0];
        }
        else{
            $doctor = Doctor::find($request->id);
        }
        $schedules = $doctor -> schedule;
        $fastestDate = "no";
        $workDay = "no";
        for ($x = 1; $x < 29; $x++) {
            if(date('l', strtotime($x.' days', strtotime('today'))) == "Sunday"
            && $schedules->sunPeriod == 1
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5 )
            {
                $fastestDate = date("Y-m-d", strtotime('Sunday'));
                $workDay=1;
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Sunday"
            && $schedules->sunPeriod == 2
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5 ){
                $fastestDate = date("Y-m-d", strtotime('Sunday'));
                $workDay=2;
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Sunday"
            && $schedules->sunPeriod == 3 ){
              if(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime('Sunday'));
                $workDay=3;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5){
                $fastestDate = date("Y-m-d", strtotime('Sunday'));
                $workDay=1;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime('Sunday'));
                $workDay=2;
                break;
              }
            }
            //Monday
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Monday"
            && $schedules->monPeriod == 1
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
             )
            {
                $fastestDate = date("Y-m-d", strtotime('Monday'));
                $workDay=1;
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Monday"
            && $schedules->monPeriod == 2
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5 ){
                $fastestDate = date("Y-m-d", strtotime('Monday'));
                $workDay=2;
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Monday"
            && $schedules->monPeriod == 3 ){
              if(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime('Monday'));
                $workDay=3;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5){
                $fastestDate = date("Y-m-d", strtotime('Monday'));
                $workDay=1;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime('Monday'));
                $workDay=2;
                break;
              }
            }
            //Tuesday
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Tuesday"
            && $schedules->tuePeriod == 1
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5 )
            {
                $fastestDate = date("Y-m-d", strtotime('Tuesday'));
                $workDay=1;
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Tuesday"
            && $schedules->tuePeriod == 2
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5 ){
                $fastestDate = date("Y-m-d", strtotime('Tuesday'));
                $workDay=2;
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Tuesday"
            && $schedules->tuePeriod == 3 ){
              if(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime('Tuesday'));
                $workDay=3;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5){
                $fastestDate = date("Y-m-d", strtotime('Tuesday'));
                $workDay=1;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime('Tuesday'));
                $workDay=2;
                break;
              }
            }
            //Wednesday
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Wednesday"
            && $schedules->wedPeriod == 1
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5 )
            {
                $fastestDate = date("Y-m-d", strtotime('Wednesday'));
                $workDay=1;
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Wednesday"
            && $schedules->wedPeriod == 2
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5 ){
                $fastestDate = date("Y-m-d", strtotime('Wednesday'));
                $workDay=2;
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Wednesday"
            && $schedules->wedPeriod == 3 ){
              if(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime('Wednesday'));
                $workDay=3;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5){
                $fastestDate = date("Y-m-d", strtotime('Wednesday'));
                $workDay=1;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime('Wednesday'));
                $workDay=2;
                break;
              }
            }
            //Thursday
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Thursday"
            && $schedules->thuPeriod == 1
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5 )
            {
                $fastestDate = date("Y-m-d", strtotime('Thursday'));
                $workDay=1;
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Thursday"
            && $schedules->thuPeriod == 2
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5 ){
                $fastestDate = date("Y-m-d", strtotime('Thursday'));
                $workDay=2;
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Thursday"
            && $schedules->thuPeriod == 3 ){
              if(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime('Thursday'));
                $workDay=3;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5){
                $fastestDate = date("Y-m-d", strtotime('Thursday'));
                $workDay=1;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime('Thursday'));
                $workDay=2;
                break;
              }
            }
            //Friday
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Friday"
            && $schedules->friPeriod == 1
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5 )
            {
                $fastestDate = date("Y-m-d", strtotime('Friday'));
                $workDay=1;
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Friday"
            && $schedules->friPeriod == 2
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5 ){
                $fastestDate = date("Y-m-d", strtotime('Friday'));
                $workDay=2;
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Friday"
            && $schedules->friPeriod == 3 ){
              if(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime('Friday'));
                $workDay=3;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5){
                $fastestDate = date("Y-m-d", strtotime('Friday'));
                $workDay=1;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime('Friday'));
                $workDay=2;
                break;
              }
            }
            //Satday
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Satday"
            && $schedules->satPeriod == 1
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5 )
            {
                $fastestDate = date("Y-m-d", strtotime('Satday'));
                $workDay=1;
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Satday"
            && $schedules->satPeriod == 2
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5 ){
                $fastestDate = date("Y-m-d", strtotime('Satday'));
                $workDay=2;
                break;
            }
            elseif(date('l', strtotime($x.' days', strtotime('today'))) == "Satday"
            && $schedules->satPeriod == 3 ){
              if(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime('Satday'));
                $workDay=3;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5){
                $fastestDate = date("Y-m-d", strtotime('Satday'));
                $workDay=1;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime('Satday'));
                $workDay=2;
                break;
              }
            }
        }

        $scheduleArray = array();

            if($schedules->sunPeriod == 0){
                $tmp = array("sunPeriod", "10");
                array_push($scheduleArray, $tmp);
            }
            else{
                $tmp = array("sunPeriod", "0");
                array_push($scheduleArray, $tmp);
            }
            if($schedules->monPeriod == 0){
                $tmp = array("monPeriod", "10");
                array_push($scheduleArray, $tmp);
            }
            else{
                $tmp = array("monPeriod", "1");
                array_push($scheduleArray, $tmp);
            }
            if($schedules->tuePeriod == 0){
                $tmp = array("tuePeriod", "10");
                array_push($scheduleArray, $tmp);
            }
            else{
                $tmp = array("tuePeriod", "2");
                array_push($scheduleArray, $tmp);
            }
            if($schedules->wedPeriod == 0){
                $tmp = array("wedPeriod", "10");
                array_push($scheduleArray, $tmp);
            }
            else{
                $tmp = array("wedPeriod", "3");
                array_push($scheduleArray, $tmp);
            }
            if($schedules->thuPeriod == 0){
                $tmp = array("thuPeriod", "10");
                array_push($scheduleArray, $tmp);
            }
            else{
                $tmp = array("thuPeriod", "4");
                array_push($scheduleArray, $tmp);
            }
            if($schedules->friPeriod == 0){
                $tmp = array("friPeriod", "10");
                array_push($scheduleArray, $tmp);
            }
            else{
                $tmp = array("friPeriod", "5");
                array_push($scheduleArray, $tmp);
            }
            if($schedules->satPeriod == 0){
                $tmp = array("satPeriod", "10");
                array_push($scheduleArray, $tmp);
            }
            else{
                $tmp = array("satPeriod", "6");
                array_push($scheduleArray, $tmp);
            }
            $tmp = array("fastestDate", $fastestDate);
            array_push($scheduleArray, $tmp);
            $tmp = array("fastestTime", $workDay);
            array_push($scheduleArray, $tmp);
        return $scheduleArray;
    }

    public function queryPeriod(Request $request){
        $schedules = Doctor::find($request->id) -> schedule;
        $day = $request->day;
        if ($day==0) return $schedules->sunPeriod;
        elseif ($day==1) return $schedules->monPeriod;
        elseif ($day==2) return $schedules->tuePeriod;
        elseif ($day==3) return $schedules->wedPeriod;
        elseif ($day==4) return $schedules->thuPeriod;
        elseif ($day==5) return $schedules->friPeriod;
        elseif ($day==6) return $schedules->satPeriod;

    }

}
