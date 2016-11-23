<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateAppointmentRequest;

use App\Model\Appointment;
use App\Model\Doctor;
use App\Model\Patient;
use App\Model\User;
use App\Model\Department;
use DB;
use App\Model\Schedule;
use App\Model\Leaving;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;

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
//        $appointment = Appointment::where('patientId', session('userId'))->where('appDate', '=', date('Y-m-d', strtotime('today')))->get();
        $appointment = Appointment::where('patientId', session('userId'))->get();
//        $appointment = Appointment::all();
        return view('appointment.index', [
            'appointments' => $appointment
        ]);
    }

    public function staffIndex()
    {
        //return session('name');
        $appointment = Appointment::where('appDate', '=', date('Y-m-d', strtotime('today')))->get();
        return view('appointment.staffindex1', [
            'appointments' => $appointment
        ]);
    }

    public function staffIndexAll()
    {
        //return session('name');
        $appointment = Appointment::where('appDate', '>=', date('Y-m-d', strtotime('today')))->get();
        return view('appointment.staffindex1', [
            'appointments' => $appointment
        ]);
    }

    public function create()
    {
        $department = Department::all();
        return view('appointment.create', [
            'departments' => $department
        ]);
    }

    public function store(CreateAppointmentRequest $request)
    {
        $countAppointment = Appointment::where('appDate', $request->appDate)->where('doctorId', $request->doctorId)->where('patientId', session('userId'))->get();

//        dd($request);
//        dd($countAppointment);

        if ( sizeof($countAppointment) > 0) {
            session(['errorSameAppointment'=>'value']);

            return redirect()->action('AppointmentController@create');
        }

        $user = User::where('userId', session('userId'))->first();
        if ($user->idNumber === $request->patientId or $user->patient->hn === $request->patientId) {
            $appointment = new Appointment();
            $appointment->symptom = $request->symptom;
            if ($request->doctorId == "0") {
                $appointment->doctorId = Department::find($request->departmentId)->doctor[0]->doctorId;
            } else {
                $appointment->doctorId = $request->doctorId;
            }
            $appointment->appDate = $request->appDate;
            if ($request->appTime == "1") {
                $appointment->appTime = "9:00";
            } elseif ($request->appTime == "2") {
                $appointment->appTime = "13:00";
            }

            $appointment->patientId = $request->session()->get('userId');//wait for user login
            $appointment->save();


            //Finished saving

//            ====================================================================================================
//            ====================================================================================================
//            ====================================================================================================
//            ====================================================================================================

            //Start sending sms

            $appDoctor = User::where('userId', $appointment->doctorId)->first();

            $url = "https://sms.gipsic.com/api/send";
            $msgContent = "นัดหมาย " . $appointment->appDate . " เวลา " . $appointment->appTime;
            $message2 = "> ทำนัดหมายสำเร็จ! วันที่นัดคือ " . $appointment->appDate . " เวลา " . $appointment->appTime . " | ทำนัดกับแพทย์ " . $appDoctor->firstname . " " . $appDoctor->lastname . " <";

            $data = array(
                'key' => 'lj13D83fe7vi4QYpB4rP4S707XRhr5Ya',
                'secret' => 'LmqK5guuSIdvwy1iF538182D2Wu4Wm44',
                'phone' => $user->phoneNumber,
                'sender' => '0969155659',
                'message' => $msgContent
            );

            $content = json_encode($data);

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                array("Content-type: application/json"));
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

            $json_response = curl_exec($curl);

            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);

            $response = json_decode($json_response, true);

//            ====================================================================================================
//            ====================================================================================================
//            ====================================================================================================
//            ====================================================================================================

            //Start sending email

            $title = 'การนัดหมายเสร็จสมบูรณ์ -- Whippedcream system';
            $content = $message2;

            Mail::send('email.send', ['title' => $title, 'content' => $content], function ($message) use ($title, $user) {
                $message->from('whippedcream@hotmail.com', 'Tkk24');
                $message->to($user->email);
                $message->subject($title);
            });

            session(['createAppSuccess' => 'true']);

            //return
            return redirect()->action('AppointmentController@index');
        }

        return back()->withErrors('e');
    }

    public function staffCreate()
    {
        $department = Department::all();
        return view('appointment.staffcreate1', [
            'departments' => $department
        ]);
    }

    public function staffStore(Request $request)
    {
//        return dd($request->all());
        $patient = User::where('idNumber', $request->patientId)->first();
        $appointment = Appointment::find($request->hn);
        $appointment = new Appointment();
        $appointment->symptom = $request->symptom;
        if ($request->doctorId == "0") {
            $appointment->doctorId = Department::find($request->departmentId)->doctor[0]->doctorId;
        } else {
            $appointment->doctorId = $request->doctorId;
        }
        $appointment->appDate = $request->appDate;
        if ($request->appTime == "1") {
            $appointment->appTime = "9:00";
        } elseif ($request->appTime == "2") {
            $appointment->appTime = "13:00";
        }


        $appointment->patientId = $patient->patient->patientId;


        $appointment->save();


        $user = User::where('idNumber', $request->patientId)->first();
        $appDoctor = User::where('userId', $appointment->doctorId)->first();

        $url = "https://sms.gipsic.com/api/send";
        $msgContent = "นัดหมาย " . $appointment->appDate . " เวลา " . $appointment->appTime;
        $message2 = "> ทำนัดหมายสำเร็จ! วันที่นัดคือ " . $appointment->appDate . " เวลา " . $appointment->appTime . " | ทำนัดกับแพทย์ " . $appDoctor->firstname . " " . $appDoctor->lastname . " <";

        $data = array(
            'key' => 'lj13D83fe7vi4QYpB4rP4S707XRhr5Ya',
            'secret' => 'LmqK5guuSIdvwy1iF538182D2Wu4Wm44',
            'phone' => $user->phoneNumber,
            'sender' => '0969155659',
            'message' => $msgContent
        );

        $content = json_encode($data);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        $response = json_decode($json_response, true);

        //Start sending email

        $title = 'การนัดหมายเสร็จสมบูรณ์ -- Whippedcream system';
        $content = $message2;

        Mail::send('email.send', ['title' => $title, 'content' => $content], function ($message) use ($title, $user) {
            $message->from('whippedcream@hotmail.com', 'Tkk24');
            $message->to($user->email);
            $message->subject($title);
        });

        session(['createAppSuccess' => 'true']);


        return redirect()->action('AppointmentController@staffIndex');

    }

    public function walkInCreate()
    {
        $department = Department::all();
        return view('appointment.walkincreate1', [
            'departments' => $department
        ]);
    }

    public function walkInStore(Request $request)
    {
//        return dd($request->all());
        $patient = User::where('idNumber', $request->patientId)->first();
        $appointment = Appointment::find($request->hn);
        $appointment = new Appointment();
        $appointment->symptom = $request->symptom;
        if ($request->doctorId == "0") {
            $appointment->doctorId = Department::find($request->departmentId)->doctor[0]->doctorId;
        } else {
            $appointment->doctorId = $request->doctorId;
        }
        $appointment->appDate = $request->appDate;
        if ($request->appTime == "1") {
            $appointment->appTime = "9:00";
        } elseif ($request->appTime == "2") {
            $appointment->appTime = "13:00";
        }


        $appointment->patientId = $patient->patient->patientId;


        $appointment->save();


        $user = User::where('idNumber', $request->patientId)->first();
        $appDoctor = User::where('userId', $appointment->doctorId)->first();

        $url = "https://sms.gipsic.com/api/send";
        $msgContent = "นัดหมาย " . $appointment->appDate . " เวลา " . $appointment->appTime;
        $message2 = "> ทำนัดหมายสำเร็จ! วันที่นัดคือ " . $appointment->appDate . " เวลา " . $appointment->appTime . " | ทำนัดกับแพทย์ " . $appDoctor->firstname . " " . $appDoctor->lastname . " <";

        $data = array(
            'key' => 'lj13D83fe7vi4QYpB4rP4S707XRhr5Ya',
            'secret' => 'LmqK5guuSIdvwy1iF538182D2Wu4Wm44',
            'phone' => $user->phoneNumber,
            'sender' => '0969155659',
            'message' => $msgContent
        );

        $content = json_encode($data);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        $response = json_decode($json_response, true);

        //Start sending email

        $title = 'การนัดหมายเสร็จสมบูรณ์ -- Whippedcream system';
        $content = $message2;

        Mail::send('email.send', ['title' => $title, 'content' => $content], function ($message) use ($title, $user) {
            $message->from('whippedcream@hotmail.com', 'Tkk24');
            $message->to($user->email);
            $message->subject($title);
        });

        session(['createAppSuccess' => 'true']);


        return redirect()->action('AppointmentController@staffIndex');
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
        $appointment->appDate = $request->appDate;
        if ($request->appTime == "1") {
            $appointment->appTime = "9:00";
        } elseif ($request->appTime == "2") {
            $appointment->appTime = "13:00";
        }
        $appointment->update();
        return redirect()->action('AppointmentController@index');
    }

    public function destroy($appointment)
    {
        Appointment::destroy($appointment);
//        if(session('userType') === 'staff'){
//            return back();
//        }
        return back();
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

    public function queryDoctorWalkIn(Request $request)
    {
        $workday = "";
        $alldoctor = Doctor::where('departmentId', '=', $request->id);
        if (date('l', strtotime('today')) == "Monday") {
            $alldoctor = DB::table('schedule')->join('doctor', 'doctor.doctorId', '=', 'schedule.doctorId')->where('departmentId', '=', $request->id)->where('monPeriod', '!=', 0)->get();
            $workday = "monPeriod";
        } elseif (date('l', strtotime('today')) == "Tuesday") {
            $alldoctor = DB::table('schedule')->join('doctor', 'doctor.doctorId', '=', 'schedule.doctorId')->where('departmentId', '=', $request->id)->where('tuePeriod', '!=', 0)->get();
            $workday = "tuePeriod";
        } elseif (date('l', strtotime('today')) == "Wednesday") {
            $alldoctor = DB::table('schedule')->join('doctor', 'doctor.doctorId', '=', 'schedule.doctorId')->where('departmentId', '=', $request->id)->where('wedPeriod', '!=', 0)->get();
            $workday = "wedPeriod";
        } elseif (date('l', strtotime('today')) == "Thursday") {
            $alldoctor = DB::table('schedule')->join('doctor', 'doctor.doctorId', '=', 'schedule.doctorId')->where('departmentId', '=', $request->id)->where('thuPeriod', '!=', 0)->get();
            $workday = "thuPeriod";
        } elseif (date('l', strtotime('today')) == "Friday") {
            $alldoctor = DB::table('schedule')->join('doctor', 'doctor.doctorId', '=', 'schedule.doctorId')->where('departmentId', '=', $request->id)->where('friPeriod', '!=', 0)->get();
            $workday = "friPeriod";
        } elseif (date('l', strtotime('today')) == "Saturday") {
            $alldoctor = DB::table('schedule')->join('doctor', 'doctor.doctorId', '=', 'schedule.doctorId')->where('departmentId', '=', $request->id)->where('satPeriod', '!=', 0)->get();
            $workday = "satPeriod";
        } elseif (date('l', strtotime('today')) == "Sunday") {
            $alldoctor = DB::table('schedule')->join('doctor', 'doctor.doctorId', '=', 'schedule.doctorId')->where('departmentId', '=', $request->id)->where('sunPeriod', '!=', 0)->get();
            $workday = "sunPeriod";
        }
        $doctors = array();
        foreach ($alldoctor as $doctor) {
            $doctorTmp = Doctor::find($doctor->doctorId);
            $leavePeriodCount = Leaving::where('leaveDate', "=", date('Y-m-d', strtotime('today')))->where('doctorId', "=", $doctor->doctorId)->count();
            $leavePeriod = Leaving::where('leaveDate', "=", date('Y-m-d', strtotime('today')))->where('doctorId', "=", $doctor->doctorId)->get();

            if ($leavePeriodCount != 0) {
                if ($workday == 'monPeriod') {
                    if ($leavePeriod[0]->leavePeriod == "3") {
                        continue;
                    } elseif ($leavePeriod[0]->leavePeriod == $doctor->monPeriod) {
                        continue;
                    }
                } elseif ($workday == 'tuePeriod') {
                    if ($leavePeriod[0]->leavePeriod == "3") {
                        continue;
                    } elseif ($leavePeriod[0]->leavePeriod == $doctor->tuePeriod) {
                        continue;
                    }
                } elseif ($workday == 'wedPeriod') {
                    if ($leavePeriod[0]->leavePeriod == "3") {
                        continue;
                    } elseif ($leavePeriod[0]->leavePeriod == $doctor->wedPeriod) {
                        continue;
                    }
                } elseif ($workday == 'thuPeriod') {
                    if ($leavePeriod[0]->leavePeriod == "3") {
                        continue;
                    } elseif ($leavePeriod[0]->leavePeriod == $doctor->thuPeriod) {
                        continue;
                    }
                } elseif ($workday == 'friPeriod') {
                    if ($leavePeriod[0]->leavePeriod == "3") {
                        continue;
                    } elseif ($leavePeriod[0]->leavePeriod == $doctor->friPeriod) {
                        continue;
                    }
                } elseif ($workday == 'satPeriod') {
                    if ($leavePeriod[0]->leavePeriod == "3") {
                        continue;
                    } elseif ($leavePeriod[0]->leavePeriod == $doctor->satPeriod) {
                        continue;
                    }
                } elseif ($workday == 'sunPeriod') {
                    if ($leavePeriod[0]->leavePeriod == "3") {
                        continue;
                    } elseif ($leavePeriod[0]->leavePeriod == $doctor->sunPeriod) {
                        continue;
                    }
                }
            }


            $tmp = array($doctorTmp->doctorId, $doctorTmp->user->firstname, $doctorTmp->user->lastname);
            array_push($doctors, $tmp);
        }
        return $doctors;
    }


    public function queryPeriodWalkIn(Request $request)
    {
        $alldoctor = Doctor::where('departmentId', '=', $request->id);
        if (date('l', strtotime('today')) == "Monday") {
            $alldoctor = DB::table('schedule')->join('doctor', 'doctor.doctorId', '=', 'schedule.doctorId')->where('departmentId', '=', $request->id)->where('monPeriod', '!=', 0)->get();
        } elseif (date('l', strtotime('today')) == "Tuesday") {
            $alldoctor = DB::table('schedule')->join('doctor', 'doctor.doctorId', '=', 'schedule.doctorId')->where('departmentId', '=', $request->id)->where('tuePeriod', '!=', 0)->get();
        } elseif (date('l', strtotime('today')) == "Wednesday") {
            $alldoctor = DB::table('schedule')->join('doctor', 'doctor.doctorId', '=', 'schedule.doctorId')->where('departmentId', '=', $request->id)->where('wedPeriod', '!=', 0)->get();
        } elseif (date('l', strtotime('today')) == "Thursday") {
            $alldoctor = DB::table('schedule')->join('doctor', 'doctor.doctorId', '=', 'schedule.doctorId')->where('departmentId', '=', $request->id)->where('thuPeriod', '!=', 0)->get();
        } elseif (date('l', strtotime('today')) == "Friday") {
            $alldoctor = DB::table('schedule')->join('doctor', 'doctor.doctorId', '=', 'schedule.doctorId')->where('departmentId', '=', $request->id)->where('friPeriod', '!=', 0)->get();
        } elseif (date('l', strtotime('today')) == "Saturday") {
            $alldoctor = DB::table('schedule')->join('doctor', 'doctor.doctorId', '=', 'schedule.doctorId')->where('departmentId', '=', $request->id)->where('satPeriod', '!=', 0)->get();
        } elseif (date('l', strtotime('today')) == "Sunday") {
            $alldoctor = DB::table('schedule')->join('doctor', 'doctor.doctorId', '=', 'schedule.doctorId')->where('departmentId', '=', $request->id)->where('sunPeriod', '!=', 0)->get();
        }
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
        if ($request->id == "0") {
            $department = Department::find($request->departmentId);
            $doctor = $department->doctor[0];
        } else {
            $doctor = Doctor::find($request->id);
        }
        $schedules = $doctor->schedule;
        $fastestDate = "no";
        $workDay = "no";
        //Leaving on morning find the lists > leavingMornDates
        $leavingMornDatesQuerys = DB::table('leaving')->select(DB::raw('leaveDate'))->where('doctorId', '=', $doctor->doctorId)->where('leavePeriod', '=', 1)->get();
        $leavingMornDates = array();
        foreach ($leavingMornDatesQuerys as $leavingMornDatesQuery) {
            array_push($leavingMornDates, $leavingMornDatesQuery->leaveDate);
        }
        //Leaving on afternoon find the list ..
        $leavingAfterDatesQuerys = DB::table('leaving')->select(DB::raw('leaveDate'))->where('doctorId', '=', $doctor->doctorId)->where('leavePeriod', '=', 2)->get();
        $leavingAfterDates = array();
        foreach ($leavingAfterDatesQuerys as $leavingAfterDatesQuery) {
            array_push($leavingAfterDates, $leavingAfterDatesQuery->leaveDate);
        }
        //Leaveing on both
        $leavingBothDatesQuerys = DB::table('leaving')->select(DB::raw('leaveDate'))->where('doctorId', '=', $doctor->doctorId)->where('leavePeriod', '=', 3)->get();
        $leavingBothDates = array();
        foreach ($leavingBothDatesQuerys as $leavingBothDatesQuery) {
            array_push($leavingBothDates, $leavingBothDatesQuery->leaveDate);
        }
        //find fastset date and time in next month
        for ($x = 1; $x < 32; $x++) {
            $day = date('l', strtotime($x . ' days', strtotime('today')));
            $date = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
            if ($day == "Sunday"
                && $schedules->sunPeriod == 1
                && Appointment::where('appDate', '=', $date)
                    ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                && !in_array($date, $leavingMornDates)
            ) {
                $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                $workDay = 1;
                break;
            } elseif ($day == "Sunday"
                && $schedules->sunPeriod == 2
                && Appointment::where('appDate', '=', $date)
                    ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                && !in_array($date, $leavingAfterDates)
            ) {
                $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                $workDay = 2;
                break;
            } elseif ($day == "Sunday"
                && $schedules->sunPeriod == 3 && !in_array($date, $leavingBothDates)
                && Appointment::where('appDate', '=', $date)
                    ->where('doctorId', '=', $doctor->doctorId)->count() < 10
            ) {
                if (Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && !in_array($date, $leavingMornDates) && !in_array($date, $leavingMornDates)
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 3;
                    break;
                } elseif (Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && (Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() >= 5
                        || in_array($date, $leavingAfterDates))
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 1;
                    break;
                } elseif ((Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() >= 5
                        || in_array($date, $leavingMornDates))
                    && Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 2;
                    break;
                }
            } //Monday
            elseif ($day == "Monday"
                && $schedules->monPeriod == 1
                && Appointment::where('appDate', '=', $date)
                    ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                && !in_array($date, $leavingMornDates)
            ) {
                $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                $workDay = 1;
                break;
            } elseif ($day == "Monday"
                && $schedules->monPeriod == 2
                && Appointment::where('appDate', '=', $date)
                    ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                && !in_array($date, $leavingAfterDates)
            ) {
                $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                $workDay = 2;
                break;
            } elseif ($day == "Monday"
                && $schedules->monPeriod == 3 && !in_array($date, $leavingBothDates)
                && Appointment::where('appDate', '=', $date)
                    ->where('doctorId', '=', $doctor->doctorId)->count() < 10
            ) {
                if (Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && !in_array($date, $leavingMornDates) && !in_array($date, $leavingAfterDates)
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 3;
                    break;
                } elseif (Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && (Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() >= 5
                        || in_array($date, $leavingAfterDates))
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 1;
                    break;
                } elseif ((Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() >= 5
                        || in_array($date, $leavingMornDates))
                    && Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 2;
                    break;
                }
            } //Tuesday
            elseif ($day == "Tuesday"
                && $schedules->tuePeriod == 1
                && Appointment::where('appDate', '=', $date)
                    ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                && !in_array($date, $leavingMornDates)
            ) {
                $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                $workDay = 1;
                break;
            } elseif ($day == "Tuesday"
                && $schedules->tuePeriod == 2
                && Appointment::where('appDate', '=', $date)
                    ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                && !in_array($date, $leavingAfterDates)
            ) {
                $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                $workDay = 2;
                break;
            } elseif ($day == "Tuesday"
                && $schedules->tuePeriod == 3 && !in_array($date, $leavingBothDates)
                && Appointment::where('appDate', '=', $date)
                    ->where('doctorId', '=', $doctor->doctorId)->count() < 10
            ) {
                if (Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && !in_array($date, $leavingMornDates) && !in_array($date, $leavingAfterDates)
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 3;
                    break;
                } elseif (Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && (Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() >= 5
                        || in_array($date, $leavingAfterDates))
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 1;
                    break;
                } elseif ((Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() >= 5
                        || in_array($date, $leavingMornDates))
                    && Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 2;
                    break;
                }
            } //Wednesday
            elseif ($day == "Wednesday"
                && $schedules->wedPeriod == 1
                && Appointment::where('appDate', '=', $date)
                    ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                && !in_array($date, $leavingMornDates)
            ) {
                $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                $workDay = 1;
                break;
            } elseif ($day == "Wednesday"
                && $schedules->wedPeriod == 2
                && Appointment::where('appDate', '=', $date)
                    ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                && !in_array($date, $leavingAfterDates)
            ) {
                $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                $workDay = 2;
                break;
            } elseif ($day == "Wednesday"
                && $schedules->wedPeriod == 3 && !in_array($date, $leavingBothDates)
                && Appointment::where('appDate', '=', $date)
                    ->where('doctorId', '=', $doctor->doctorId)->count() < 10
            ) {
                if (Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && !in_array($date, $leavingMornDates) && !in_array($date, $leavingAfterDates)
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 3;
                    break;
                } elseif (Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && (Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() >= 5
                        || in_array($date, $leavingAfterDates))
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 1;
                    break;
                } elseif ((Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() >= 5
                        || in_array($date, $leavingMornDates))
                    && Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 2;
                    break;
                }
            } //Thursday
            elseif ($day == "Thursday"
                && $schedules->thuPeriod == 1
                && Appointment::where('appDate', '=', $date)
                    ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                && !in_array($date, $leavingMornDates)
            ) {
                $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                $workDay = 1;
                break;
            } elseif ($day == "Thursday"
                && $schedules->thuPeriod == 2
                && Appointment::where('appDate', '=', $date)
                    ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                && !in_array($date, $leavingAfterDates)
            ) {
                $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                $workDay = 2;
                break;
            } elseif ($day == "Thursday"
                && $schedules->thuPeriod == 3 && !in_array($date, $leavingBothDates)
                && Appointment::where('appDate', '=', $date)
                    ->where('doctorId', '=', $doctor->doctorId)->count() < 10
            ) {
                if (Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && !in_array($date, $leavingMornDates) && !in_array($date, $leavingAfterDates)
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 3;
                    break;
                } elseif (Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && (Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() >= 5
                        || in_array($date, $leavingAfterDates))
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 1;
                    break;
                } elseif ((Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() >= 5
                        || in_array($date, $leavingMornDates))
                    && Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 2;
                    break;
                }
            } //Friday
            elseif ($day == "Friday"
                && $schedules->friPeriod == 1
                && Appointment::where('appDate', '=', $date)
                    ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                && !in_array($date, $leavingMornDates)
            ) {
                $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                $workDay = 1;
                break;
            } elseif ($day == "Friday"
                && $schedules->friPeriod == 2
                && Appointment::where('appDate', '=', $date)
                    ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                && !in_array($date, $leavingAfterDates)
            ) {
                $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                $workDay = 2;
                break;
            } elseif ($day == "Friday"
                && $schedules->friPeriod == 3 && !in_array($date, $leavingBothDates)
                && Appointment::where('appDate', '=', $date)
                    ->where('doctorId', '=', $doctor->doctorId)->count() < 10
            ) {
                if (Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && !in_array($date, $leavingMornDates) && !in_array($date, $leavingAfterDates)
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 3;
                    break;
                } elseif (Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && (Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() >= 5
                        || in_array($date, $leavingAfterDates))
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 1;
                    break;
                } elseif ((Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() >= 5
                        || in_array($date, $leavingMornDates))
                    && Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 2;
                    break;
                }
            } //Saturday
            elseif ($day == "Saturday"
                && $schedules->satPeriod == 1
                && Appointment::where('appDate', '=', $date)
                    ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                && !in_array($date, $leavingMornDates)
            ) {
                $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                $workDay = 1;
                break;
            } elseif ($day == "Saturday"
                && $schedules->satPeriod == 2
                && Appointment::where('appDate', '=', $date)
                    ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                && !in_array($date, $leavingAfterDates)
            ) {
                $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                $workDay = 2;
                break;
            } elseif ($day == "Saturday"
                && $schedules->satPeriod == 3 && !in_array($date, $leavingBothDates)
                && Appointment::where('appDate', '=', $date)
                    ->where('doctorId', '=', $doctor->doctorId)->count() < 10
            ) {
                if (Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && !in_array($date, $leavingMornDates) && !in_array($date, $leavingAfterDates)
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 3;
                    break;
                } elseif (Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                    && (Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() >= 5
                        || in_array($date, $leavingAfterDates))
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 1;
                    break;
                } elseif ((Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $doctor->doctorId)->count() >= 5
                        || in_array($date, $leavingMornDates))
                    && Appointment::where('appDate', '=', $date)
                        ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $doctor->doctorId)->count() < 5
                ) {
                    $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    $workDay = 2;
                    break;
                }

            }
        }

        $disabledDates = array();
        $hisApps = DB::table('appointment')->select(DB::raw('doctorId,appDate,count(*) as count'))->where('doctorId', '=', $doctor->doctorId)->groupBy('doctorId')->groupBy('appDate')->get();
        foreach ($hisApps as $hisApp) {
            $day = date('l', strtotime($hisApp->appDate));
            if ($day == "Monday") {
                if (Schedule::where('doctorId', '=', $doctor->doctorId)->get()[0]->monPeriod < 3
                    && $hisApp->count >= 5
                ) {
                    array_push($disabledDates, $hisApp->appDate);
                } else if (Schedule::where('doctorId', '=', $doctor->doctorId)->get()[0]->monPeriod == 3
                ) {
                    if ($hisApp->count >= 10) array_push($disabledDates, $hisApp->appDate);
                    elseif (((in_array(($hisApp->appDate), $leavingMornDates))
                            || (in_array(($hisApp->appDate), $leavingAfterDates)))
                        && $hisApp->count >= 5
                    ) array_push($disabledDates, $hisApp->appDate);
                }
            } elseif ($day == "Sunday") {
                if (Schedule::where('doctorId', '=', $doctor->doctorId)->get()[0]->sunPeriod < 3
                    && $hisApp->count >= 5
                ) {
                    array_push($disabledDates, $hisApp->appDate);
                } else if (Schedule::where('doctorId', '=', $doctor->doctorId)->get()[0]->sunPeriod == 3
                ) {
                    if ($hisApp->count >= 10) array_push($disabledDates, $hisApp->appDate);
                    elseif (((in_array(($hisApp->appDate), $leavingMornDates))
                            || (in_array(($hisApp->appDate), $leavingAfterDates)))
                        && $hisApp->count >= 5
                    ) array_push($disabledDates, $hisApp->appDate);
                }
            } elseif ($day == "Tuesday") {
                if (Schedule::where('doctorId', '=', $doctor->doctorId)->get()[0]->tuePeriod < 3
                    && $hisApp->count >= 5
                ) {
                    array_push($disabledDates, $hisApp->appDate);
                } else if (Schedule::where('doctorId', '=', $doctor->doctorId)->get()[0]->tuePeriod == 3
                ) {
                    if ($hisApp->count >= 10) array_push($disabledDates, $hisApp->appDate);
                    elseif (((in_array(($hisApp->appDate), $leavingMornDates))
                            || (in_array(($hisApp->appDate), $leavingAfterDates)))
                        && $hisApp->count >= 5
                    ) array_push($disabledDates, $hisApp->appDate);
                }
            } elseif ($day == "Wednesday") {
                if (Schedule::where('doctorId', '=', $doctor->doctorId)->get()[0]->wedPeriod < 3
                    && $hisApp->count >= 5
                ) {
                    array_push($disabledDates, $hisApp->appDate);
                } else if (Schedule::where('doctorId', '=', $doctor->doctorId)->get()[0]->wedPeriod == 3
                ) {
                    if ($hisApp->count >= 10) array_push($disabledDates, $hisApp->appDate);
                    elseif (((in_array(($hisApp->appDate), $leavingMornDates))
                            || (in_array(($hisApp->appDate), $leavingAfterDates)))
                        && $hisApp->count >= 5
                    ) array_push($disabledDates, $hisApp->appDate);
                }
            } elseif ($day == "Thursday") {
                if (Schedule::where('doctorId', '=', $doctor->doctorId)->get()[0]->thuPeriod < 3
                    && $hisApp->count >= 5
                ) {
                    array_push($disabledDates, $hisApp->appDate);
                } else if (Schedule::where('doctorId', '=', $doctor->doctorId)->get()[0]->thuPeriod == 3
                ) {
                    if ($hisApp->count >= 10) array_push($disabledDates, $hisApp->appDate);
                    elseif (((in_array(($hisApp->appDate), $leavingMornDates))
                            || (in_array(($hisApp->appDate), $leavingAfterDates)))
                        && $hisApp->count >= 5
                    ) array_push($disabledDates, $hisApp->appDate);
                }
            } elseif ($day == "Friday") {
                if (Schedule::where('doctorId', '=', $doctor->doctorId)->get()[0]->friPeriod < 3
                    && $hisApp->count >= 5
                ) {
                    array_push($disabledDates, $hisApp->appDate);
                } else if (Schedule::where('doctorId', '=', $doctor->doctorId)->get()[0]->friPeriod == 3
                ) {
                    if ($hisApp->count >= 10) array_push($disabledDates, $hisApp->appDate);
                    elseif (((in_array(($hisApp->appDate), $leavingMornDates))
                            || (in_array(($hisApp->appDate), $leavingAfterDates)))
                        && $hisApp->count >= 5
                    ) array_push($disabledDates, $hisApp->appDate);
                }
            } elseif ($day == "Saturday") {
                if (Schedule::where('doctorId', '=', $doctor->doctorId)->get()[0]->satPeriod < 3
                    && $hisApp->count >= 5
                ) {
                    array_push($disabledDates, $hisApp->appDate);
                } else if (Schedule::where('doctorId', '=', $doctor->doctorId)->get()[0]->satPeriod == 3) {
                    if ($hisApp->count >= 10) array_push($disabledDates, $hisApp->appDate);
                    elseif (((in_array(($hisApp->appDate), $leavingMornDates))
                            || (in_array(($hisApp->appDate), $leavingAfterDates)))
                        && $hisApp->count >= 5
                    ) array_push($disabledDates, $hisApp->appDate);
                }
            }
        }

        //เชคในลิส "วันในตอนเช้าที่หมอคนนี้ลาทั้งหมด" แล้วดูทีละวัน ถ้าวันนั้นตรงกับวันที่ออกตรวจประจำและช่วงเวลาออกตรวจก็เป็นเช้าด้วยก็จะยัดวัดนั้นเข้า disabledDates
        foreach ($leavingMornDates as $leavingMornDate) {
            if (date('l', strtotime($leavingMornDate)) == "Sunday" && $schedules->sunPeriod == 1) array_push($disabledDates, $leavingMornDate);
            elseif (date('l', strtotime($leavingMornDate)) == "Monday" && $schedules->monPeriod == 1) array_push($disabledDates, $leavingMornDate);
            elseif (date('l', strtotime($leavingMornDate)) == "Tuesday" && $schedules->tuePeriod == 1) array_push($disabledDates, $leavingMornDate);
            elseif (date('l', strtotime($leavingMornDate)) == "Wednesday" && $schedules->wedPeriod == 1) array_push($disabledDates, $leavingMornDate);
            elseif (date('l', strtotime($leavingMornDate)) == "Thursday" && $schedules->thuPeriod == 1) array_push($disabledDates, $leavingMornDate);
            elseif (date('l', strtotime($leavingMornDate)) == "Friday" && $schedules->friPeriod == 1) array_push($disabledDates, $leavingMornDate);
            elseif (date('l', strtotime($leavingMornDate)) == "Saturday" && $schedules->satPeriod == 1) array_push($disabledDates, $leavingMornDate);
        }
        //คล้ายๆข้างบน เป็น ตอนบ่าย
        foreach ($leavingAfterDates as $leavingAfterDate) {
            if (date('l', strtotime($leavingAfterDate)) == "Sunday" && $schedules->sunPeriod == 2) array_push($disabledDates, $leavingAfterDate);
            elseif (date('l', strtotime($leavingAfterDate)) == "Monday" && $schedules->monPeriod == 2) array_push($disabledDates, $leavingAfterDate);
            elseif (date('l', strtotime($leavingAfterDate)) == "Tuesday" && $schedules->tuePeriod == 2) array_push($disabledDates, $leavingAfterDate);
            elseif (date('l', strtotime($leavingAfterDate)) == "Wednesday" && $schedules->wedPeriod == 2) array_push($disabledDates, $leavingAfterDate);
            elseif (date('l', strtotime($leavingAfterDate)) == "Thursday" && $schedules->thuPeriod == 2) array_push($disabledDates, $leavingAfterDate);
            elseif (date('l', strtotime($leavingAfterDate)) == "Friday" && $schedules->friPeriod == 2) array_push($disabledDates, $leavingAfterDate);
            elseif (date('l', strtotime($leavingAfterDate)) == "Saturday" && $schedules->satPeriod == 2) array_push($disabledDates, $leavingAfterDate);
        }
        foreach ($leavingBothDates as $leavingBothDate) {
            array_push($disabledDates, $leavingBothDate);
        }


        $scheduleArray = array();
        if ($schedules->sunPeriod == 0) {
            $tmp = array("sunPeriod", "10");
            array_push($scheduleArray, $tmp);
        } else {
            $tmp = array("sunPeriod", "0");
            array_push($scheduleArray, $tmp);
        }
        if ($schedules->monPeriod == 0) {
            $tmp = array("monPeriod", "10");
            array_push($scheduleArray, $tmp);
        } else {
            $tmp = array("monPeriod", "1");
            array_push($scheduleArray, $tmp);
        }
        if ($schedules->tuePeriod == 0) {
            $tmp = array("tuePeriod", "10");
            array_push($scheduleArray, $tmp);
        } else {
            $tmp = array("tuePeriod", "2");
            array_push($scheduleArray, $tmp);
        }
        if ($schedules->wedPeriod == 0) {
            $tmp = array("wedPeriod", "10");
            array_push($scheduleArray, $tmp);
        } else {
            $tmp = array("wedPeriod", "3");
            array_push($scheduleArray, $tmp);
        }
        if ($schedules->thuPeriod == 0) {
            $tmp = array("thuPeriod", "10");
            array_push($scheduleArray, $tmp);
        } else {
            $tmp = array("thuPeriod", "4");
            array_push($scheduleArray, $tmp);
        }
        if ($schedules->friPeriod == 0) {
            $tmp = array("friPeriod", "10");
            array_push($scheduleArray, $tmp);
        } else {
            $tmp = array("friPeriod", "5");
            array_push($scheduleArray, $tmp);
        }
        if ($schedules->satPeriod == 0) {
            $tmp = array("satPeriod", "10");
            array_push($scheduleArray, $tmp);
        } else {
            $tmp = array("satPeriod", "6");
            array_push($scheduleArray, $tmp);
        }
        $tmp = array("fastestDate", $fastestDate);
        array_push($scheduleArray, $tmp);
        $tmp = array("fastestTime", $workDay);
        array_push($scheduleArray, $tmp);
        array_push($scheduleArray, $disabledDates);
        //เพิ่มตรง toDayPeriod สำหรับ walkIn
        $toDay = date('l', strtotime('today'));
        if ($toDay == "Sunday") {
            $tmp = array("toDayPeriod", Doctor::find($doctor->doctorId)->schedule->sunPeriod);
        } elseif ($toDay == "Monday") {
            $tmp = array("toDayPeriod", Doctor::find($doctor->doctorId)->schedule->monPeriod);
        } elseif ($toDay == "Tuesday") {
            $tmp = array("toDayPeriod", Doctor::find($doctor->doctorId)->schedule->tuePeriod);
        } elseif ($toDay == "Wednesday") {
            $tmp = array("toDayPeriod", Doctor::find($doctor->doctorId)->schedule->wedPeriod);
        } elseif ($toDay == "Thursday") {
            $tmp = array("toDayPeriod", Doctor::find($doctor->doctorId)->schedule->thuPeriod);
        } elseif ($toDay == "Friday") {
            $tmp = array("toDayPeriod", Doctor::find($doctor->doctorId)->schedule->friPeriod);
        } elseif ($toDay == "Saturday") {
            $tmp = array("toDayPeriod", Doctor::find($doctor->doctorId)->schedule->satPeriod);
        }
        array_push($scheduleArray, $tmp);
        return $scheduleArray;
    }

    public function queryPeriod(Request $request)
    {
        $schedules = Doctor::find($request->id)->schedule;
        $day = $request->day;
        $dd = $request->date;
        $mm = $request->month;
        $yy = $request->year;
        //แก้ให้ตรง format จาก 3 > 03
        if ($dd < 10) $dd = '0' . $dd;
        if ($mm < 10) $mm = '0' . $mm;
        $newDate = $yy . '-' . $mm . '-' . $dd;

        $numberOfAppOnNewDateMorn = Appointment::where('appDate', '=', $newDate)->where('appTime', '=', '09:00:00')->where('doctorId', '=', $request->id)->count();
        $numberOfAppOnNewDateAfte = Appointment::where('appDate', '=', $newDate)->where('appTime', '=', '13:00:00')->where('doctorId', '=', $request->id)->count();
        $newDateInfo = Leaving::where('doctorId', '=', $request->id)->where('leaveDate', '=', $newDate)->get();
        //กำหนดค่าเริ่มต้น
        $newDateLeavePeriod = 0;
        //ถ้ามีการขอลาในวันนั้น เก็บใส่ $newDateLeavePeriod ว่าลาช่วงไหน
        if (sizeof($newDateInfo) != 0) {
            $newDateLeavePeriod = $newDateInfo[0]->leavePeriod;
        }

        if ($day == 0 && ($schedules->sunPeriod == 1 || $schedules->sunPeriod == 2)) return $schedules->sunPeriod;
        elseif ($day == 0 && $schedules->sunPeriod == 3) {
            {
                if ($numberOfAppOnNewDateMorn < 5 && ($numberOfAppOnNewDateAfte >= 5 || $newDateLeavePeriod == 2)) return 1;
                elseif (($numberOfAppOnNewDateMorn >= 5 || $newDateLeavePeriod == 1) && $numberOfAppOnNewDateAfte < 5) return 2;
                elseif ($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte < 5) return 3;
            }
        } elseif ($day == 1 && ($schedules->monPeriod == 1 || $schedules->monPeriod == 2)) return $schedules->monPeriod;
        elseif ($day == 1 && $schedules->monPeriod == 3) {
            {
                if ($numberOfAppOnNewDateMorn < 5 && ($numberOfAppOnNewDateAfte >= 5 || $newDateLeavePeriod == 2)) return 1;
                elseif (($numberOfAppOnNewDateMorn >= 5 || $newDateLeavePeriod == 1) && $numberOfAppOnNewDateAfte < 5) return 2;
                elseif ($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte < 5) return 3;
            }
        } elseif ($day == 2 && ($schedules->tuePeriod == 1 || $schedules->tuePeriod == 2)) return $schedules->tuePeriod;
        elseif ($day == 2 && $schedules->tuePeriod == 3) {
            {
                if ($numberOfAppOnNewDateMorn < 5 && ($numberOfAppOnNewDateAfte >= 5 || $newDateLeavePeriod == 2)) return 1;
                elseif (($numberOfAppOnNewDateMorn >= 5 || $newDateLeavePeriod == 1) && $numberOfAppOnNewDateAfte < 5) return 2;
                elseif ($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte < 5) return 3;
            }
        } elseif ($day == 3 && ($schedules->wedPeriod == 1 || $schedules->wedPeriod == 2)) return $schedules->wedPeriod;
        elseif ($day == 3 && $schedules->wedPeriod == 3) {
            {
                if ($numberOfAppOnNewDateMorn < 5 && ($numberOfAppOnNewDateAfte >= 5 || $newDateLeavePeriod == 2)) return 1;
                elseif (($numberOfAppOnNewDateMorn >= 5 || $newDateLeavePeriod == 1) && $numberOfAppOnNewDateAfte < 5) return 2;
                elseif ($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte < 5) return 3;
            }
        } elseif ($day == 4 && ($schedules->thuPeriod == 1 || $schedules->thuPeriod == 2)) return $schedules->thuPeriod;
        elseif ($day == 4 && $schedules->thuPeriod == 3) {
            {
                if ($numberOfAppOnNewDateMorn < 5 && ($numberOfAppOnNewDateAfte >= 5 || $newDateLeavePeriod == 2)) return 1;
                elseif (($numberOfAppOnNewDateMorn >= 5 || $newDateLeavePeriod == 1) && $numberOfAppOnNewDateAfte < 5) return 2;
                elseif ($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte < 5) return 3;
            }
        } elseif ($day == 5 && ($schedules->friPeriod == 1 || $schedules->friPeriod == 2)) return $schedules->friPeriod;
        elseif ($day == 5 && $schedules->friPeriod == 3) {
            {
                if ($numberOfAppOnNewDateMorn < 5 && ($numberOfAppOnNewDateAfte >= 5 || $newDateLeavePeriod == 2)) return 1;
                elseif (($numberOfAppOnNewDateMorn >= 5 || $newDateLeavePeriod == 1) && $numberOfAppOnNewDateAfte < 5) return 2;
                elseif ($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte < 5) return 3;
            }
        } elseif ($day == 6 && ($schedules->satPeriod == 1 || $schedules->satPeriod == 2)) return $schedules->satPeriod;
        elseif ($day == 6 && $schedules->satPeriod == 3) {
            {
                if ($numberOfAppOnNewDateMorn < 5 && ($numberOfAppOnNewDateAfte >= 5 || $newDateLeavePeriod == 2)) return 1;
                elseif (($numberOfAppOnNewDateMorn >= 5 || $newDateLeavePeriod == 1) && $numberOfAppOnNewDateAfte < 5) return 2;
                elseif ($numberOfAppOnNewDateMorn < 5 && $numberOfAppOnNewDateAfte < 5) return 3;
            }
        }
    }

    public function staffSearchPatient()
    {
        $patients = array();
        return view('appointment.staffsearchpatient', compact('patients'));
    }

    public function staffSearchPatientFound(Request $request)
    {
        $patients_hn = Patient::where('hn', $request->input('hnNumber'))->value('patientId');
        $patients = User::where('userId', $patients_hn)->first();
        if ($patients == '') {
            $patients = User::where('idNumber', $request->input('idNumber'))->first();
            if ($patients == '') {
                $patients = User::where('firstname', $request->input('firstname'))->where('lastname', $request->input('lastname'))->first();
                if ($patients == '') {
                    $patients = array();
                    return view('appointment.staffsearchpatient', compact('patients'));
                }
            }
            $patients_hn = Patient::where('patientId', $patients->userId)->value('patientId');
        }
        $appointments = Appointment::where('patientId', $patients_hn)->get();
        return view('appointment.staffindex1', compact('appointments'));
    }

}
