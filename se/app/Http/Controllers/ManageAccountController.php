<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\Patient;
use App\Model\Doctor;
use App\Model\Nurse;
use App\Model\Staff;
use App\Model\Pharmacist;
use App\Model\Admin;
use App\Model\Schedule;
use App\Model\Appointment;
use Request;

/*use Illuminate\Http\Request;*/

class ManageAccountController extends Controller
{
    public function display_users()
    {
        $input = Request::all();
        $users = User::all();
        if (count($input) == 0) {
            $name = '';
            $dep = '';
            $ssn = '';
            $id = '';
            $wanted_userType = ['Patient', 'Staff', 'Doctor', 'Nurse', 'Pharmacist', 'Admin'];
            for ($i = 0; $i < count($users); $i++) {
                $users[$i]['index'] = $i + 1;
            }

            return view('admin.manageAccount', compact('users', 'name', 'dep', 'ssn', 'id', 'wanted_userType') );
        }
        $input = self::clearNull($input);
        $name = strtolower($input['name']);
        $dep = strtolower($input['department']);
        $ssn = $input['ssn'];
        $id = $input['id'];
        $match_users = [];
        for ($i = 0; $i < count($users); $i++) {
            $qualify = True;
            /*check if name is qualified*/
            if ($name != "") {
                $name = trim($name);
                $name = preg_replace('/\s+/', ' ', $name);
                $space_index = strpos($name, ' ');
                if ($space_index === False) {
                    $space_index = "False";
                }
                $user_fn = strtolower($users[$i]['firstname']);
                $user_ln = strtolower($users[$i]['lastname']);
                if ($space_index != "False") {
                    $firstname = substr($name, 0, $space_index);
                    $lastname = substr($name, $space_index + 1);
                    if (strpos($user_fn, $firstname) === False) {
                        $qualify = False;
                    }
                    if (strpos($user_ln, $lastname) === False) {
                        $qualify = False;
                    }
                } else {
                    if ((strpos($user_fn, $name) === False) and (strpos($user_ln, $name) === False)) {
                        $qualify = False;
                    }
                }
            }
            /*check if despartment is qualified*/
            if ($dep != "") {
                if ($users[$i]['userType'] == 'Doctor' or $users[$i]['userType'] == 'Nurse') {
                    $user_dep = '';
                    if ($users[$i]['userType'] == 'Doctor') {
                        $user_dep = strtolower($users[$i]->doctor->department['departmentName']);
                    } else {
                        $user_dep = strtolower($users[$i]->nurse->department['departmentName']);
                    }
                    if (strpos($user_dep, $dep) == False) {
                        $qualify = False;
                    }
                } else {
                    $qualify = False;
                }

            }
            /*check if ssn is qualified*/
            if ($ssn != "") {
                if ($ssn != $users[$i]['ssn']) {
                    $qualify = False;
                }
            }
            /*check if patient/staff number is qualified*/
            if ($id != "") {
                if ($users[$i]['userType'] == 'patient') {
                    if ($id != $users[$i]->patient['hn']) {
                        $qualify = False;
                    }
                } elseif ($users[$i]['userType'] == 'staff') {
                    if ($id != $users[$i]->staff['staffNumber']) {
                        $qualify = False;
                    }
                } elseif ($users[$i]['userType'] == 'doctor') {
                    if ($id != $users[$i]->doctor['doctorNumber']) {
                        $qualify = False;
                    }
                } elseif ($users[$i]['userType'] == 'nurse') {
                    if ($id != $users[$i]->nurse['nurseNumber']) {
                        $qualify = False;
                    }
                } elseif ($users[$i]['userType'] == 'pharmacist') {
                    if ($id != $users[$i]->pharmacist['pharmacistNumber']) {
                        $qualify = False;
                    }
                } else {
                    if ($id != $users[$i]->admin['adminNumber']) {
                        $qualify = False;
                    }
                }
            }
            /*check if userType is qualified*/
            $wanted_userType = [];
            array_push($wanted_userType, $input['userType_Pa']);
            array_push($wanted_userType, $input['userType_S']);
            array_push($wanted_userType, $input['userType_D']);
            array_push($wanted_userType, $input['userType_N']);
            array_push($wanted_userType, $input['userType_Ph']);
            array_push($wanted_userType, $input['userType_A']);
            if (!in_array($users[$i]['userType'], $wanted_userType)) {
                $qualify = False;
            }
            if ($qualify) {
                array_push($match_users, $users[$i]);
            }
        }
        for ($i = 0; $i < count($match_users); $i++) {
            $match_users[$i]['index'] = $i + 1;
        }
        $users = $match_users;
        $name = $input['name'];
        $dep = $input['department'];
        $ssn = $input['ssn'];
        $id = $input['id'];
        return view('admin.manageAccount', compact('users', 'name', 'dep', 'ssn', 'id', 'wanted_userType'));
    }

    private function clearNull($input)
    {
        if (!isset($input['name'])) {
            $input['name'] = "";
        }
        if (!isset($input['department'])) {
            $input['department'] = "";
        }
        if (!isset($input['ssn'])) {
            $input['ssn'] = "";
        }
        if (!isset($input['id'])) {
            $input['id'] = "";
        }
        if (!isset($input['userType_Pa'])) {
            $input['userType_Pa'] = "";
        }
        if (!isset($input['userType_S'])) {
            $input['userType_S'] = "";
        }
        if (!isset($input['userType_D'])) {
            $input['userType_D'] = "";
        }
        if (!isset($input['userType_N'])) {
            $input['userType_N'] = "";
        }
        if (!isset($input['userType_Ph'])) {
            $input['userType_Ph'] = "";
        }
        if (!isset($input['userType_A'])) {
            $input['userType_A'] = "";
        }
        return $input;
    }

    public function edit_user()
    {
        $input = Request::all();
        if ($input['operation'] == 'change_right') {
            /*code change right*/
        } else if ($input['operation'] == 'delete') {

            $target_user = User::where('username', $input['username'])->first();
            $target_userType = '';
            if ($target_user->userType == 'patient') {
                $target_userType = $target_user->patient;
            } elseif ($target_user->userType == 'staff') {
                $target_userType = $target_user->staff;
            } elseif ($target_user->userType == 'doctor') {
                date_default_timezone_set('Asia/Bangkok');
                $today = new \DateTime('now');
                $today = $today->format('Y-m-d');
                $all_app = $target_user->doctor->appointment;
                if (count($all_app) > 0) {
                    for ($i = 0; $i < count($all_app); $i++) {
                        if ($all_app[$i]['appDate'] == $today) {
                            session()->flash('delete_doc_error', 1);
                            return redirect('manageAccount');
                        }
                    }
                    for ($i = 0; $i < count($all_app); $i++) {
                        /*PostponeAppointmentController::postponeAppointment($all_app[$i]);*/
                    }
                }
                $target_userType = $target_user->doctor;
                $target_schedule = $target_user->doctor->schedule;
                $target_schedule->delete();
            } elseif ($target_user->userType == 'nurse') {
                $target_userType = $target_user->nurse;
            } elseif ($target_user->userType == 'pharmacist') {
                $target_userType = $target_user->pharmacist;
            } elseif ($target_user->userType == 'admin') {
                $target_userType = $target_user->admin;
            }
            $target_userType->delete();
            $target_user->delete();
        }
        return redirect('manageAccount');
    }
}
