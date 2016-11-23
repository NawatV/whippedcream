<?php

//Flow: No.2-Controller

namespace App\Http\Controllers;

use App\Model\Appointment;
use App\Model\Patient;
use Illuminate\Http\Request;
use App\Model\Department;
use App\Model\User;
use App\Model\Doctor;
use App\Model\Staff;
use App\Model\Schedule;
use App\Model\Leaving;
use Illuminate\Support\Facades\DB;

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
        $doctor = Doctor::where('doctorId', $userId)->first(); //doctorNumber ?
        $staff = Staff::where('staffId', $userId)->first(); //staffNumber ?

        if (count($doctor) == 1) {

            $sche = Schedule::where('doctorId', $userId)->first();
            $abs = Leaving::where('doctorId', $userId)->get(); //get all rows in this condition in $ads (array)

            $pack = array(
                'sche' => $sche,
                'abs' => $abs
            );

            return view('schedule', compact('pack', 'sche'));   //MUST USE THIS
            //return view('schedule')->with($pack);
            //return View::make('schedule')->with($pack);
        } else if (count($staff) == 1) {
            $pack = array();
            return view('schedule', compact('pack'));   //MUST USE THIS
        } else {
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
        $leavingId = rand(0, 9999999);   //FIX LATER

        $userId = $request->session()->get('userId');

        $absentdate = $request->input('absentdate');
        $tmp = strtotime($absentdate);
        $leaveDate = date('Y-m-d', $tmp);

        $absentperiod = $request->input('absentperiod');

        //return dd($absentperiod);

        //------- query in DBs : https://laravel.com/docs/5.3/queries#deletes --------
        //$newabs = Leaving::insert('insert into leaving (leavingId, doctorId, leaveDate, leavePeriod) values(4, $userId, $absentdate, $absentperiod)');    
        //leavingId ?



        $oldLeave = Leaving::where('doctorId',session('userId'))->get();
        foreach ($oldLeave as $ol){
            if($ol->leaveDate === $leaveDate){
                session(['errorSameLeave' => 'value']);
                return back();
            }
        }





        $theabsent = new Leaving([
            'leavingId' => $leavingId, // $absentdate
            'doctorId' => $userId,
            'leaveDate' => $leaveDate,
            'leavePeriod' => $absentperiod
        ]);

        //$theabsent->patient()->associate($patient);
        //$vitalSignData->nurse()->associate($nurse);
        $theabsent->save();


        session(['alertConfirmAbsent' => 'value']);

        $time = '';
        if ($absentperiod === '3') {
            $appointmentInThatPeriod = Appointment::where('doctorId', session('userId'))->where('appDate', $leaveDate)->get();
        } else {
            if ($absentperiod === '1') $time = '09:00:00';
            else {
                $time = '13:00:00';
            }
            $appointmentInThatPeriod = Appointment::where('doctorId', session('userId'))->where('appDate', $leaveDate)->where('appTime', $time)->get();
        }

//        dd($appointmentInThatPeriod);
        $sche = Schedule::where('doctorId', $userId)->first();


        $tmpAppointmentInThatPeriod = $appointmentInThatPeriod;
        foreach ($appointmentInThatPeriod as $newAppointment) {
            $newAppointment->delete();
        }
        foreach ($tmpAppointmentInThatPeriod as $tmp) {

            if (1 == 1) {


                $fastestDate = "no";
                $workDay = "no";
                //Leaving on morning find the lists > leavingMornDates
                $leavingMornDatesQuerys = DB::table('leaving')->select(DB::raw('leaveDate'))->where('doctorId', '=', $userId)->where('leavePeriod', '=', 1)->get();
                $leavingMornDates = array();
                foreach ($leavingMornDatesQuerys as $leavingMornDatesQuery) {
                    array_push($leavingMornDates, $leavingMornDatesQuery->leaveDate);
                }
                //Leaving on afternoon find the list ..
                $leavingAfterDatesQuerys = DB::table('leaving')->select(DB::raw('leaveDate'))->where('doctorId', '=', $userId)->where('leavePeriod', '=', 2)->get();
                $leavingAfterDates = array();
                foreach ($leavingAfterDatesQuerys as $leavingAfterDatesQuery) {
                    array_push($leavingAfterDates, $leavingAfterDatesQuery->leaveDate);
                }
                //Leaveing on both
                $leavingBothDatesQuerys = DB::table('leaving')->select(DB::raw('leaveDate'))->where('doctorId', '=', $userId)->where('leavePeriod', '=', 3)->get();
                $leavingBothDates = array();
                foreach ($leavingBothDatesQuerys as $leavingBothDatesQuery) {
                    array_push($leavingBothDates, $leavingBothDatesQuery->leaveDate);
                }
                //find fastset date and time in next month
                for ($x = 1; $x < 32; $x++) {
                    $day = date('l', strtotime($x . ' days', strtotime('today')));
                    $date = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                    if ($day == "Sunday"
                        && $sche->sunPeriod == 1
                        && Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                        && !in_array($date, $leavingMornDates)
                    ) {
                        $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                        $workDay = 1;
                        break;
                    } elseif ($day == "Sunday"
                        && $sche->sunPeriod == 2
                        && Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                        && !in_array($date, $leavingAfterDates)
                    ) {
                        $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                        $workDay = 2;
                        break;
                    } elseif ($day == "Sunday"
                        && $sche->sunPeriod == 3 && !in_array($date, $leavingBothDates)
                        && Appointment::where('appDate', '=', $date)
                            ->where('doctorId', '=', $userId)->count() < 10
                    ) {
                        if (Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && !in_array($date, $leavingMornDates) && !in_array($date, $leavingMornDates)
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 3;
                            break;
                        } elseif (Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && (Appointment::where('appDate', '=', $date)
                                    ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() >= 5
                                || in_array($date, $leavingAfterDates))
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 1;
                            break;
                        } elseif ((Appointment::where('appDate', '=', $date)
                                    ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() >= 5
                                || in_array($date, $leavingMornDates))
                            && Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 2;
                            break;
                        }
                    } //Monday
                    elseif ($day == "Monday"
                        && $sche->monPeriod == 1
                        && Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                        && !in_array($date, $leavingMornDates)
                    ) {
                        $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                        $workDay = 1;
                        break;
                    } elseif ($day == "Monday"
                        && $sche->monPeriod == 2
                        && Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                        && !in_array($date, $leavingAfterDates)
                    ) {
                        $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                        $workDay = 2;
                        break;
                    } elseif ($day == "Monday"
                        && $sche->monPeriod == 3 && !in_array($date, $leavingBothDates)
                        && Appointment::where('appDate', '=', $date)
                            ->where('doctorId', '=', $userId)->count() < 10
                    ) {
                        if (Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && !in_array($date, $leavingMornDates) && !in_array($date, $leavingAfterDates)
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 3;
                            break;
                        } elseif (Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && (Appointment::where('appDate', '=', $date)
                                    ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() >= 5
                                || in_array($date, $leavingAfterDates))
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 1;
                            break;
                        } elseif ((Appointment::where('appDate', '=', $date)
                                    ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() >= 5
                                || in_array($date, $leavingMornDates))
                            && Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 2;
                            break;
                        }
                    } //Tuesday
                    elseif ($day == "Tuesday"
                        && $sche->tuePeriod == 1
                        && Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                        && !in_array($date, $leavingMornDates)
                    ) {
                        $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                        $workDay = 1;
                        break;
                    } elseif ($day == "Tuesday"
                        && $sche->tuePeriod == 2
                        && Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                        && !in_array($date, $leavingAfterDates)
                    ) {
                        $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                        $workDay = 2;
                        break;
                    } elseif ($day == "Tuesday"
                        && $sche->tuePeriod == 3 && !in_array($date, $leavingBothDates)
                        && Appointment::where('appDate', '=', $date)
                            ->where('doctorId', '=', $userId)->count() < 10
                    ) {
                        if (Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && !in_array($date, $leavingMornDates) && !in_array($date, $leavingAfterDates)
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 3;
                            break;
                        } elseif (Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && (Appointment::where('appDate', '=', $date)
                                    ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() >= 5
                                || in_array($date, $leavingAfterDates))
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 1;
                            break;
                        } elseif ((Appointment::where('appDate', '=', $date)
                                    ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() >= 5
                                || in_array($date, $leavingMornDates))
                            && Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 2;
                            break;
                        }
                    } //Wednesday
                    elseif ($day == "Wednesday"
                        && $sche->wedPeriod == 1
                        && Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                        && !in_array($date, $leavingMornDates)
                    ) {
                        $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                        $workDay = 1;
                        break;
                    } elseif ($day == "Wednesday"
                        && $sche->wedPeriod == 2
                        && Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                        && !in_array($date, $leavingAfterDates)
                    ) {
                        $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                        $workDay = 2;
                        break;
                    } elseif ($day == "Wednesday"
                        && $sche->wedPeriod == 3 && !in_array($date, $leavingBothDates)
                        && Appointment::where('appDate', '=', $date)
                            ->where('doctorId', '=', $userId)->count() < 10
                    ) {
                        if (Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && !in_array($date, $leavingMornDates) && !in_array($date, $leavingAfterDates)
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 3;
                            break;
                        } elseif (Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && (Appointment::where('appDate', '=', $date)
                                    ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() >= 5
                                || in_array($date, $leavingAfterDates))
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 1;
                            break;
                        } elseif ((Appointment::where('appDate', '=', $date)
                                    ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() >= 5
                                || in_array($date, $leavingMornDates))
                            && Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 2;
                            break;
                        }
                    } //Thursday
                    elseif ($day == "Thursday"
                        && $sche->thuPeriod == 1
                        && Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                        && !in_array($date, $leavingMornDates)
                    ) {
                        $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                        $workDay = 1;
                        break;
                    } elseif ($day == "Thursday"
                        && $sche->thuPeriod == 2
                        && Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                        && !in_array($date, $leavingAfterDates)
                    ) {
                        $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                        $workDay = 2;
                        break;
                    } elseif ($day == "Thursday"
                        && $sche->thuPeriod == 3 && !in_array($date, $leavingBothDates)
                        && Appointment::where('appDate', '=', $date)
                            ->where('doctorId', '=', $userId)->count() < 10
                    ) {
                        if (Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && !in_array($date, $leavingMornDates) && !in_array($date, $leavingAfterDates)
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 3;
                            break;
                        } elseif (Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && (Appointment::where('appDate', '=', $date)
                                    ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() >= 5
                                || in_array($date, $leavingAfterDates))
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 1;
                            break;
                        } elseif ((Appointment::where('appDate', '=', $date)
                                    ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() >= 5
                                || in_array($date, $leavingMornDates))
                            && Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 2;
                            break;
                        }
                    } //Friday
                    elseif ($day == "Friday"
                        && $sche->friPeriod == 1
                        && Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                        && !in_array($date, $leavingMornDates)
                    ) {
                        $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                        $workDay = 1;
                        break;
                    } elseif ($day == "Friday"
                        && $sche->friPeriod == 2
                        && Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                        && !in_array($date, $leavingAfterDates)
                    ) {
                        $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                        $workDay = 2;
                        break;
                    } elseif ($day == "Friday"
                        && $sche->friPeriod == 3 && !in_array($date, $leavingBothDates)
                        && Appointment::where('appDate', '=', $date)
                            ->where('doctorId', '=', $userId)->count() < 10
                    ) {
                        if (Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && !in_array($date, $leavingMornDates) && !in_array($date, $leavingAfterDates)
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 3;
                            break;
                        } elseif (Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && (Appointment::where('appDate', '=', $date)
                                    ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() >= 5
                                || in_array($date, $leavingAfterDates))
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 1;
                            break;
                        } elseif ((Appointment::where('appDate', '=', $date)
                                    ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() >= 5
                                || in_array($date, $leavingMornDates))
                            && Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 2;
                            break;
                        }
                    } //Saturday
                    elseif ($day == "Saturday"
                        && $sche->satPeriod == 1
                        && Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                        && !in_array($date, $leavingMornDates)
                    ) {
                        $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                        $workDay = 1;
                        break;
                    } elseif ($day == "Saturday"
                        && $sche->satPeriod == 2
                        && Appointment::where('appDate', '=', $date)
                            ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                        && !in_array($date, $leavingAfterDates)
                    ) {
                        $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                        $workDay = 2;
                        break;
                    } elseif ($day == "Saturday"
                        && $sche->satPeriod == 3 && !in_array($date, $leavingBothDates)
                        && Appointment::where('appDate', '=', $date)
                            ->where('doctorId', '=', $userId)->count() < 10
                    ) {
                        if (Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && !in_array($date, $leavingMornDates) && !in_array($date, $leavingAfterDates)
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 3;
                            break;
                        } elseif (Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() < 5
                            && (Appointment::where('appDate', '=', $date)
                                    ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() >= 5
                                || in_array($date, $leavingAfterDates))
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 1;
                            break;
                        } elseif ((Appointment::where('appDate', '=', $date)
                                    ->where('appTime', '=', '09:00:00')->where('doctorId', '=', $userId)->count() >= 5
                                || in_array($date, $leavingMornDates))
                            && Appointment::where('appDate', '=', $date)
                                ->where('appTime', '=', '13:00:00')->where('doctorId', '=', $userId)->count() < 5
                        ) {
                            $fastestDate = date("Y-m-d", strtotime($x . ' days', strtotime('today')));
                            $workDay = 2;
                            break;
                        }

                    }

                }

            }

//            $fastestDate;
//            $workDay;
//            dd($fastestDate);
//            dd($workDay);

            $exactTime ='';
            if($workDay == 1) $exactTime = '09:00:00';
            else $exactTime = '13:00:00';
//
            $tmp->appDate = $fastestDate;
            $tmp->appTime = $exactTime;
            $tmp->save();
        }


//        $appointmentOfDoctor = Appointment::where('doctorId',session('userId'))->get();


//        $patientsInThatPeriod = Patient::where('','');


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
            $staff = Staff::where('staffId', $userId)->first();

            if (count($staff) == 1) {

                $searchId = $request->input('searchId');

                $sche = Schedule::where('doctorId', $searchId)->first();
                $abs = Leaving::where('doctorId', $searchId)->get(); //get all rows in this condition in $ads (array)

                $pack = array();

                if (count($sche) > 0 || count($abs) > 0) {
                    $pack = array(
                        'sche' => $sche,
                        'abs' => $abs
                    );
                }


                return view('schedule', compact('pack'));   //MUST USE THIS
                //return view('schedule')->with($pack);
                //return View::make('schedule')->with($pack);
            } else {
                return redirect('login');
            }

            //----for staff----
            //show in desktop?

            //return view('schedule');
        }

        public
        function queryAbsentPeriod(Request $request)
        {
            $userId = $request->session()->get('userId');
            $sche = Schedule::where('doctorId', $userId)->first();
            $day = $request->day;
            $dd = $request->date;
            $mm = $request->month;
            $yy = $request->year;
            //แก้ให้ตรง format จาก 3 > 03
            if ($dd < 10) $dd = '0' . $dd;
            if ($mm < 10) $mm = '0' . $mm;
            $newDate = $yy . '-' . $mm . '-' . $dd;


            if ($day == 0 && ($sche->sunPeriod == 1 || $sche->sunPeriod == 2)) return $sche->sunPeriod;
            elseif ($day == 0 && $sche->sunPeriod == 3) {
                {
                    return 3;
                }
            } elseif ($day == 1 && ($sche->monPeriod == 1 || $sche->monPeriod == 2)) return $sche->monPeriod;
            elseif ($day == 1 && $sche->monPeriod == 3) {
                {
                    return 3;
                }
            } elseif ($day == 2 && ($sche->tuePeriod == 1 || $sche->tuePeriod == 2)) return $sche->tuePeriod;
            elseif ($day == 2 && $sche->tuePeriod == 3) {
                {
                    return 3;
                }
            } elseif ($day == 3 && ($sche->wedPeriod == 1 || $sche->wedPeriod == 2)) return $sche->wedPeriod;
            elseif ($day == 3 && $sche->wedPeriod == 3) {
                {
                    return 3;
                }
            } elseif ($day == 4 && ($sche->thuPeriod == 1 || $sche->thuPeriod == 2)) return $sche->thuPeriod;
            elseif ($day == 4 && $sche->thuPeriod == 3) {
                {
                    return 3;
                }
            } elseif ($day == 5 && ($sche->friPeriod == 1 || $sche->friPeriod == 2)) return $sche->friPeriod;
            elseif ($day == 5 && $sche->friPeriod == 3) {
                {
                    return 3;
                }
            } elseif ($day == 6 && ($sche->satPeriod == 1 || $sche->satPeriod == 2)) return $sche->satPeriod;
            elseif ($day == 6 && $sche->satPeriod == 3) {
                {
                    return 3;
                }
            }
        }

    }
