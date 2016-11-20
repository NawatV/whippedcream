<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Appointment;
use App\Model\Doctor;
use App\Model\Patient;
use App\Model\User;
use App\Model\Department;
use DB;
use App\Model\Schedule;
use App\Model\Leaving;
use Barryvdh\DomPDF\Facade as PDF;

class AppointmentController extends Controller
{

    public function login_temp(Request $request)
    {
      $request->session()->put([
        'userId' => 1,
        'userType' => 'patient',
        'name' => 'firstton1 '
      ]);
      return view('welcome');
    }

    public function index()
    {
        //return session('name');
        $appointment = Appointment::where('patientId', '=', session('userId'))->where('appDate', '=', date('Y-m-d', strtotime('today')))->get();
        //$appointment = Appointment::all();
        return view('appointment.index',[
            'appointments' => $appointment
        ]);
    }

    public function staffIndex()
    {
        //return session('name');
        $appointment = Appointment::where('appDate', '=', date('Y-m-d', strtotime('today')))->get();
        return view('appointment.staffindex1',[
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
        $appointment -> symptom = $request->symptom;
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

        $appointment -> patientId = $request->session()->get('userId');//wait for user login
        $appointment -> save();
        return redirect() -> action('AppointmentController@index');
    }
    public function staffCreate()
    {
        $department = Department::all();
        return view('appointment.staffcreate1',[
            'departments' => $department
        ]);
    }

    public function staffStore(Request $request)
    {
        //return dd($request->all());
        $patient = Patient::where('hn', '=', $request->patientId)->first();    
        $appointment = Appointment::find($request->hn);
        $appointment = new Appointment();
        $appointment -> symptom = $request->symptom;
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

        $appointment -> patientId = $patient->patientId; 
        $appointment -> save();
        return redirect() -> action('AppointmentController@index');

    }
    public function walkInCreate()
    {
        $department = Department::all();
        return view('appointment.walkincreate',[
            'departments' => $department
        ]);
    }

    public function walkInStore(Request $request)
    {
        return "hello"; 
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $appointment = Appointment::find($id);
        return view('appointment.edit1', [
            'appointment' => $appointment
        ]);
    }


    public function update(Request $request)
    {
      //return dd($request->all());
      $appointment = Appointment::find($request->appointmentId);
      $appointment -> appDate = $request->appDate;
      if($request -> appTime == "1"){
          $appointment -> appTime = "9:00";
      }elseif($request -> appTime == "2"){
          $appointment -> appTime = "13:00";
      }
      $appointment->update();
      return redirect() -> action('AppointmentController@index');
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

    public function appointmentPdf($appointment)
    {
        //return dd($appointment);
        $appointments = Appointment::find($appointment);
        $pdf = PDF::loadView('appointment.appointmentpdf', compact('appointments'));
        return $pdf->stream('hello.pdf');
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
        //Leaving
        $leavings = DB::table('leaving')->select('leaveDate')->where('doctorId','=',$doctor->doctorId)->get();
        $leavingDates = array();
        foreach ($leavings as $leaving) {
          array_push($leavingDates,$leaving->leaveDate);
        }
        for ($x = 1; $x < 32; $x++) {
          $day = date('l', strtotime($x.' days', strtotime('today')));
          $date = date('Y-m-d', strtotime($x.' days', strtotime('today')));
            if($day == "Sunday"
            && $schedules->sunPeriod == 1
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
            && !in_array($date,$leavingDates)  )
            {
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=1;
                break;
            }
            elseif($day == "Sunday"
            && $schedules->sunPeriod == 2
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
            && !in_array($date,$leavingDates)  )
            {
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=2;
                break;
            }
            elseif($day == "Sunday"
            && $schedules->sunPeriod == 3  && !in_array($date,$leavingDates) ){
              if(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=3;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=1;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=2;
                break;
              }
            }
            //Monday
            elseif($day == "Monday"
            && $schedules->monPeriod == 1
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
            && !in_array($date,$leavingDates)  )
            {
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=1;
                break;
            }
            elseif($day == "Monday"
            && $schedules->monPeriod == 2
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
            && !in_array($date,$leavingDates) )
            {
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=2;
                break;
            }
            elseif($day == "Monday"
            && $schedules->monPeriod == 3  && !in_array($date,$leavingDates) ){
              if(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=3;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=1;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=2;
                break;
              }
            }
            //Tuesday
            elseif($day == "Tuesday"
            && $schedules->tuePeriod == 1
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
            && !in_array($date,$leavingDates)  )
            {
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=1;
                break;
            }
            elseif($day == "Tuesday"
            && $schedules->tuePeriod == 2
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
            && !in_array($date,$leavingDates) )
            {
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=2;
                break;
            }
            elseif($day == "Tuesday"
            && $schedules->tuePeriod == 3 && !in_array($date,$leavingDates) ){
              if(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=3;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=1;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=2;
                break;
              }
            }
            //Wednesday
            elseif($day == "Wednesday"
            && $schedules->wedPeriod == 1
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
            && !in_array($date,$leavingDates) )
            {
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=1;
                break;
            }
            elseif($day == "Wednesday"
            && $schedules->wedPeriod == 2
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
            && !in_array($date,$leavingDates)  )
            {
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=2;
                break;
            }
            elseif($day == "Wednesday"
            && $schedules->wedPeriod == 3 && !in_array($date,$leavingDates) ){
              if(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=3;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=1;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=2;
                break;
              }
            }
            //Thursday
            elseif($day == "Thursday"
            && $schedules->thuPeriod == 1
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
            && !in_array($date,$leavingDates)  )
            {
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=1;
                break;
            }
            elseif($day == "Thursday"
            && $schedules->thuPeriod == 2
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
            && !in_array($date,$leavingDates) )
            {
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=2;
                break;
            }
            elseif($day == "Thursday"
            && $schedules->thuPeriod == 3 && !in_array($date,$leavingDates)  ){
              if(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=3;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=1;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=2;
                break;
              }
            }
            //Friday
            elseif($day == "Friday"
            && $schedules->friPeriod == 1
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
            && !in_array($date,$leavingDates)  )
            {
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=1;
                break;
            }
            elseif($day == "Friday"
            && $schedules->friPeriod == 2
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
            && !in_array($date,$leavingDates)  )
            {
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=2;
                break;
            }
            elseif($day == "Friday"
            && $schedules->friPeriod == 3 && !in_array($date,$leavingDates) ){
              if(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=3;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=1;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=2;
                break;
              }
            }
            //Saturday
            elseif($day == "Saturday"
            && $schedules->satPeriod == 1
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
            && !in_array($date,$leavingDates)  )
            {
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=1;
                break;
            }
            elseif($day == "Saturday"
            && $schedules->satPeriod == 2
            && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
            ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
            && !in_array($date,$leavingDates)  ){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=2;
                break;
            }
            elseif($day == "Saturday"
            && $schedules->satPeriod == 3  && !in_array($date,$leavingDates) ){
              if(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=3;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=1;
                break;
              }elseif(Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','09:00:00')->where('doctorId','=',$doctor->doctorId)->count() >= 5
              && Appointment::where('appDate', '=', date("Y-m-d",strtotime($x.' days', strtotime('today'))))
              ->where('appTime','=','13:00:00')->where('doctorId','=',$doctor->doctorId)->count() < 5){
                $fastestDate = date("Y-m-d", strtotime($x.' days', strtotime('today')));
                $workDay=2;
                break;
              }
            }
        }

        $disabledDates = array();
        $hisApps = DB::table('appointment')->select(DB::raw('doctorId,appDate,count(*) as count'))->where('doctorId','=',$doctor->doctorId)->groupBy('doctorId')->groupBy('appDate')->get();
        foreach ($hisApps as $hisApp) {
          $day = date('l',strtotime($hisApp->appDate));
          if($day == "Monday"){
            if(Schedule::where('doctorId','=',$doctor->doctorId)->get()[0]->monPeriod < 3
            && $hisApp->count >= 5){
              array_push($disabledDates,$hisApp->appDate);
            }else if(Schedule::where('doctorId','=',$doctor->doctorId)->get()[0]->monPeriod == 3
            && $hisApp->count >= 10){
              array_push($disabledDates,$hisApp->appDate);
            }
          }elseif($day == "Sunday"){
            if(Schedule::where('doctorId','=',$doctor->doctorId)->get()[0]->sunPeriod < 3
            && $hisApp->count >= 5){
              array_push($disabledDates,$hisApp->appDate);
            }else if(Schedule::where('doctorId','=',$doctor->doctorId)->get()[0]->sunPeriod == 3
            && $hisApp->count >= 10){
              array_push($disabledDates,$hisApp->appDate);
            }
          }elseif($day == "Tuesday"){
            if(Schedule::where('doctorId','=',$doctor->doctorId)->get()[0]->tuePeriod < 3
            && $hisApp->count >= 5){
              array_push($disabledDates,$hisApp->appDate);
            }else if(Schedule::where('doctorId','=',$doctor->doctorId)->get()[0]->tuePeriod == 3
            && $hisApp->count >= 10){
              array_push($disabledDates,$hisApp->appDate);
            }
          }elseif($day == "Wednesday"){
            if(Schedule::where('doctorId','=',$doctor->doctorId)->get()[0]->wedPeriod < 3
            && $hisApp->count >= 5){
              array_push($disabledDates,$hisApp->appDate);
            }else if(Schedule::where('doctorId','=',$doctor->doctorId)->get()[0]->wedPeriod == 3
            && $hisApp->count >= 10){
              array_push($disabledDates,$hisApp->appDate);
            }
          }elseif($day == "Thursday"){
            if(Schedule::where('doctorId','=',$doctor->doctorId)->get()[0]->thuPeriod < 3
            && $hisApp->count >= 5){
              array_push($disabledDates,$hisApp->appDate);
            }else if(Schedule::where('doctorId','=',$doctor->doctorId)->get()[0]->thuPeriod == 3
            && $hisApp->count >= 10){
              array_push($disabledDates,$hisApp->appDate);
            }
          }elseif($day == "Friday"){
            if(Schedule::where('doctorId','=',$doctor->doctorId)->get()[0]->friPeriod < 3
            && $hisApp->count >= 5){
              array_push($disabledDates,$hisApp->appDate);
            }else if(Schedule::where('doctorId','=',$doctor->doctorId)->get()[0]->friPeriod == 3
            && $hisApp->count >= 10){
              array_push($disabledDates,$hisApp->appDate);
            }
          }elseif($day == "Saturday"){
            if(Schedule::where('doctorId','=',$doctor->doctorId)->get()[0]->satPeriod < 3
            && $hisApp->count >= 5){
              array_push($disabledDates,$hisApp->appDate);
            }else if(Schedule::where('doctorId','=',$doctor->doctorId)->get()[0]->satPeriod == 3
            && $hisApp->count >= 10){
              array_push($disabledDates,$hisApp->appDate);
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
            array_push($scheduleArray,$disabledDates);
        return $scheduleArray;
    }

    public function queryPeriod(Request $request){
        $schedules = Doctor::find($request->id) -> schedule;
        $day = $request->day;
        $dd = $request->date;
        $mm = $request ->month;
        $yy = $request ->year;
        $newDate = $yy.'-'.$mm.'-'.$dd;
        $numberOfAppOnNewDateMorn = Appointment::where('appDate', '=', $newDate)->where('appTime','=','09:00:00')->where('doctorId','=',$request->id)->count();
        $numberOfAppOnNewDateAfte = Appointment::where('appDate', '=', $newDate)->where('appTime','=','13:00:00')->where('doctorId','=',$request->id)->count();
        if( $day==0 && ($schedules->sunPeriod == 1 || $schedules->sunPeriod == 2) ) return $schedules->sunPeriod;
        elseif ( $day==0  && $schedules->sunPeriod == 3 ) {
          {
            if($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte >= 5) return 1;
            elseif($numberOfAppOnNewDateMorn >= 5 && $numberOfAppOnNewDateAfte < 5) return 2;
            elseif($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte < 5) return 3;
          }
        }
        elseif ( $day==1 && ($schedules->monPeriod == 1 || $schedules->monPeriod == 2) ) return $schedules->monPeriod;
        elseif ( $day==1  && $schedules->monPeriod == 3 ) {
          {
            if($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte >= 5) return 1;
            elseif($numberOfAppOnNewDateMorn >= 5 && $numberOfAppOnNewDateAfte < 5) return 2;
            elseif($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte < 5) return 3;
          }
        }
        elseif ( $day==2 && ($schedules->tuePeriod == 1 || $schedules->tuePeriod == 2) ) return $schedules->tuePeriod;
        elseif ( $day==2  && $schedules->tuePeriod == 3 ) {
          {
            if($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte >= 5) return 1;
            elseif($numberOfAppOnNewDateMorn >= 5 && $numberOfAppOnNewDateAfte < 5) return 2;
            elseif($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte < 5) return 3;
          }
        }
        elseif ( $day==3 && ($schedules->wedPeriod == 1 || $schedules->wedPeriod == 2) ) return $schedules->wedPeriod;
        elseif ( $day==3  && $schedules->wedPeriod == 3 ) {
          {
            if($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte >= 5) return 1;
            elseif($numberOfAppOnNewDateMorn >= 5 && $numberOfAppOnNewDateAfte < 5) return 2;
            elseif($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte < 5) return 3;
          }
        }
        elseif ( $day==4 && ($schedules->thuPeriod == 1 || $schedules->thuPeriod == 2) ) return $schedules->thuPeriod;
        elseif ( $day==4  && $schedules->thuPeriod == 3 ) {
          {
            if($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte >= 5) return 1;
            elseif($numberOfAppOnNewDateMorn >= 5 && $numberOfAppOnNewDateAfte < 5) return 2;
            elseif($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte < 5) return 3;
          }
        }
        elseif ( $day==5 && ($schedules->friPeriod == 1 || $schedules->friPeriod == 2) ) return $schedules->friPeriod;
        elseif ( $day==5  && $schedules->friPeriod == 3 ) {
          {
            if($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte >= 5) return 1;
            elseif($numberOfAppOnNewDateMorn >= 5 && $numberOfAppOnNewDateAfte < 5) return 2;
            elseif($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte < 5) return 3;
          }
        }
        elseif ( $day==6 && ($schedules->satPeriod == 1 || $schedules->satPeriod == 2) ) return $schedules->satPeriod;
        elseif ( $day==6  && $schedules->satPeriod == 3 ) {
          {
            if($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte >= 5) return 1;
            elseif($numberOfAppOnNewDateMorn >= 5 && $numberOfAppOnNewDateAfte < 5) return 2;
            elseif($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte < 5) return 3;
          }
        }

    }

}
