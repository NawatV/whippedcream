<?php

namespace App\Http\Controllers;

use App\Model\Admin;
use App\Model\User;
use Illuminate\Http\Request;

class FirstAdminController extends Controller
{
    public function create_admin_form()
    {
        session(['userType' => 'admin']);
        return view('admin.createAdmin');
    }
    public function create_admin(Request $request)
    {
        $input = $request;
        if($input['firstname'] == '' or $input['lastname'] == '' or $input['ssn'] == '' or $input['adminNumber'] == ''){
            session()->flash('create_admin_error', 1);
            return redirect('createAdmin');
        }
        if(!isset($input['gender'])){
            session()->flash('create_admin_error', 1);
            return redirect('createAdmin');
        }
        if($input['birthDate'] == '' or $input['email'] == '' or $input['phoneNumber'] == '' or $input['address'] == ''){
            session()->flash('create_admin_error', 1);
            return redirect('createAdmin');
        }
        $new_user = new User;
        $new_admin = new Admin;
        $new_user->firstname = $input['firstname'];
        $new_user->lastname = $input['lastname'];
        $new_user->idNumber = $input['ssn'];
        /*check ssn*/
        $is_ssn_correct = self::checkSSNFormat($input['ssn']);
        if(!$is_ssn_correct){
            session()->flash('create_admin_error', 5);
            return redirect('createAdmin');
        }
        /*end*/
        if($input['gender'] == 'ชาย'){
            $new_user->gender = 'male';
        }
        else{
            $new_user->gender = 'female';
        }
        /*check date*/
        $is_date_correct = self::checkDateFormat($input['birthDate']);
        if(!$is_date_correct){
            session()->flash('create_admin_error', 3);
            return redirect('createAdmin');
        }
        /*end*/
        $birthDate = substr($input['birthDate'], 6) . "-" . substr($input['birthDate'], 0, 2) . '-' . substr($input['birthDate'], 3, 2);
        $new_user->birthDate = $birthDate;
        $new_user->phoneNumber = $input['phoneNumber'];
        /*check phone number*/
        $is_pn_correct = self::checkPhoneNumberFormat($input['phoneNumber']);
        if(!$is_pn_correct){
            session()->flash('create_admin_error', 4);
            return redirect('createAdmin');
        }
        /*end*/
        $new_user->email = $input['email'];
        /*check email*/
        $is_email_coorect = self::checkEmailFormat($input['email']);
        if(!$is_email_coorect){
            session()->flash('create_admin_error', 6);
            return redirect('createAdmin');
        }
        /*end*/
        $at_pos = strpos($input['email'], '@');
        $new_user->username = substr($input['email'], 0, $at_pos) . "_wc";
        /*check username & adminNumber*/
        if(count(User::where('username', $new_user->username)->get()) > 0){
            session()->flash('create_admin_error', 2);
            return redirect('createAdmin');
        }
        if(count(Admin::where('adminNumber', $input['adminNumber'])->get()) > 0){
            session()->flash('create_admin_error', 2);
            return redirect('createAdmin');
        }
        /*end*/
        $new_pass = self::generatePassword();
        $new_user->password = bcrypt($new_pass);
        $new_user->address = $input['address'];
        /*thai or eng*/
        $new_user->userType = 'admin';
        try {
            $new_user->save();
        } catch(Exception $e) {
            session()->flash('create_admin_error', 2);
            return redirect('createAdmin');
        }
        $new_admin->adminId = $new_user->userId;
        $new_admin->adminNumber = $input['adminNumber'];
        try {
            $new_admin->save();
        } catch(Exception $e) {
            session()->flash('create_admin_error', 2);
            return redirect('createAdmin');
        }
        session()->flash('account_owner', $new_user->firstname . ' ' . $new_user->lastname);
        session()->flash('generated_username', $new_user->username);
        session()->flash('generated_password', $new_pass);
        return redirect('manageAccount2');
    }

    public function display_users(Request $request)
    {
        $input = $request;
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
//        $input = self::clearNull($input);
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
    private function checkDateFormat($date)
    {
        if(strlen($date) != 10){
            return False;
        }
        if (!preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $date)) {
            return False;
        }
        $valid = checkdate(substr($date, 0, 2), substr($date, 3, 2), substr($date, 6));
        return $valid;
    }
    private function checkPhoneNumberFormat($phoneNumber)
    {
        if((strlen($phoneNumber) != 10) or (!is_numeric($phoneNumber))){
            return False;
        }

        if(substr($phoneNumber, 0, 2) === '08'){
            return True;
        }
        if(substr($phoneNumber, 0, 2) === '09' ){
            return True;
        }

        return false;
    }
    private function checkSSNFormat($ssn)
    {
        if((strlen($ssn) != 13) or (!is_numeric($ssn))){
            return False;
        }
        return True;
    }
    private function checkEmailFormat($email)
    {
        if(strpos($email, '@') === False or strpos($email, ' ') !== False){
            return False;
        }
        return True;
    }
    private function generatePassword()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
