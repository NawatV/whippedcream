<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\Staff;
use App\Model\Doctor;
use App\Model\Schedule;
use App\Model\Nurse;
use App\Model\Pharmacist;
use App\Model\Admin;
use App\Model\Department;
use Request;

class CreateAccountController extends Controller
{
    public function create_staff_form()
    {
        return view('admin.createStaff');
    }

    public function create_staff()
    {
        $input = Request::all();

        if (!isset($input['gender'])) {
            $input['gender'] = '';
            session()->flash('old_value', $input);
            session()->flash('create_staff_error', 1);
            return redirect('createStaff');
        }

        if ($input['firstname'] == '' or $input['lastname'] == '' or $input['ssn'] == '' or $input['staffNumber'] == '' or $input['birthDate'] == '' or $input['email'] == '' or $input['phoneNumber'] == '' or $input['address'] == '') {
            session()->flash('old_value', $input);
            session()->flash('create_staff_error', 1);
            return redirect('createStaff');
        }
        $new_user = new User;
        $new_staff = new Staff;
        $new_user->firstname = $input['firstname'];
        $new_user->lastname = $input['lastname'];
        $new_user->idNumber = $input['ssn'];
        /*check ssn*/
        $is_ssn_correct = self::checkSSNFormat($input['ssn']);

        if (!$is_ssn_correct) {
            session()->flash('old_value', $input);
            session()->flash('create_staff_error', 5);
            return redirect('createStaff');
        }
        /*end*/
        if ($input['gender'] == 'ชาย') {
            $new_user->gender = 'male';
        } else {
            $new_user->gender = 'female';
        }
        /*check date*/
        $is_date_correct = self::checkDateFormat($input['birthDate']);

        if (!$is_date_correct) {
            session()->flash('old_value', $input);
            session()->flash('create_staff_error', 3);
            return redirect('createStaff');
        }
        /*end*/
        $birthDate = substr($input['birthDate'], 6) . "-" . substr($input['birthDate'], 0, 2) . '-' . substr($input['birthDate'], 3, 2);
        $new_user->birthDate = $birthDate;
        $new_user->phoneNumber = $input['phoneNumber'];
        /*check phone number*/
        $is_pn_correct = self::checkPhoneNumberFormat($input['phoneNumber']);

        if (!$is_pn_correct) {
            session()->flash('old_value', $input);
            session()->flash('create_staff_error', 4);
            return redirect('createStaff');
        }
        /*end*/
        $new_user->email = $input['email'];
        /*check email*/
        $is_email_coorect = self::checkEmailFormat($input['email']);

        if (!$is_email_coorect) {
            session()->flash('old_value', $input);
            session()->flash('create_staff_error', 6);
            return redirect('createStaff');
        }
        /*end*/
        $at_pos = strpos($input['email'], '@');
        $new_user->username = substr($input['email'], 0, $at_pos) . "_wc";
        /*check username & staffNumber*/

        if (count(User::where('username', $new_user->username)->get()) > 0) {
            session()->flash('old_value', $input);
            session()->flash('create_staff_error', 2);
            return redirect('createStaff');
        }

        if (count(Staff::where('staffNumber', $input['staffNumber'])->get()) > 0) {
            session()->flash('old_value', $input);
            session()->flash('create_staff_error', 2);
            return redirect('createStaff');
        }
        /*end*/
        $new_pass = self::generatePassword();
        $new_user->password = bcrypt($new_pass);
        $new_user->address = $input['address'];
        /*thai or eng*/
        $new_user->userType = 'staff';
        try {
            $new_user->save();
        } catch (Exception $e) {
            session()->flash('old_value', $input);
            session()->flash('create_staff_error', 2);
            return redirect('createStaff');
        }
        $new_staff->staffId = $new_user->userId;
        $new_staff->staffNumber = $input['staffNumber'];
        try {
            $new_staff->save();
        } catch (Exception $e) {
            session()->flash('old_value', $input);
            session()->flash('create_staff_error', 2);
            return redirect('createStaff');
        }
        session()->flash('account_owner', $new_user->firstname . ' ' . $new_user->lastname);
        session()->flash('generated_username', $new_user->username);
        session()->flash('generated_password', $new_pass);
        return redirect('manageAccount');
    }

    private function checkSSNFormat($ssn)
    {
        if ((strlen($ssn) != 13) or (!is_numeric($ssn))) {
            return False;
        }
        return True;
    }

    private function checkDateFormat($date)
    {
        if (strlen($date) != 10) {
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
        if ((strlen($phoneNumber) != 10) or (!is_numeric($phoneNumber))) {
            return False;
        }

        if (substr($phoneNumber, 0, 2) === '08') {
            return True;
        }
        if (substr($phoneNumber, 0, 2) === '09') {
            return True;
        }

        return false;
    }

    private function checkEmailFormat($email)
    {
        if (strpos($email, '@') === False or strpos($email, ' ') !== False) {
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

    public function create_doctor_form()
    {
        $available_deps = Department::all();
        return view('admin.createDoctor', compact('available_deps'));
    }

    public function create_doctor()
    {
        $input = Request::all();
        /*schedule*/
        if (!isset($input['mon_mor'])) {
            $input['mon_mor'] = 0;
        }
        if (!isset($input['mon_af'])) {
            $input['mon_af'] = 0;
        }
        if (!isset($input['tue_mor'])) {
            $input['tue_mor'] = 0;
        }
        if (!isset($input['tue_af'])) {
            $input['tue_af'] = 0;
        }
        if (!isset($input['wed_mor'])) {
            $input['wed_mor'] = 0;
        }
        if (!isset($input['wed_af'])) {
            $input['wed_af'] = 0;
        }
        if (!isset($input['thu_mor'])) {
            $input['thu_mor'] = 0;
        }
        if (!isset($input['thu_af'])) {
            $input['thu_af'] = 0;
        }
        if (!isset($input['fri_mor'])) {
            $input['fri_mor'] = 0;
        }
        if (!isset($input['fri_af'])) {
            $input['fri_af'] = 0;
        }
        if (!isset($input['sat_mor'])) {
            $input['sat_mor'] = 0;
        }
        if (!isset($input['sat_af'])) {
            $input['sat_af'] = 0;
        }
        if (!isset($input['sun_mor'])) {
            $input['sun_mor'] = 0;
        }
        if (!isset($input['sun_af'])) {
            $input['sun_af'] = 0;
        }

        if (!isset($input['gender'])) {
            $input['gender'] = '';
            session()->flash('old_value', $input);
            session()->flash('create_doc_error', 1);
            return redirect('createDoctor');
        }

        if ($input['firstname'] == '' or $input['lastname'] == '' or $input['ssn'] == '' or $input['doctorNumber'] == '' or $input['birthDate'] == '' or $input['email'] == '' or $input['phoneNumber'] == '' or $input['address'] == '') {
            session()->flash('old_value', $input);
            session()->flash('create_doc_error', 1);
            return redirect('createDoctor');
        }
        $new_user = new User;
        $new_doctor = new Doctor;
        $new_user->firstname = $input['firstname'];
        $new_user->lastname = $input['lastname'];
        $new_user->idNumber = $input['ssn'];
        /*check ssn*/
        $is_ssn_correct = self::checkSSNFormat($input['ssn']);

        if (!$is_ssn_correct) {
            session()->flash('old_value', $input);
            session()->flash('create_doc_error', 5);
            return redirect('createDoctor');
        }
        /*end*/
        if ($input['gender'] == 'ชาย') {
            $new_user->gender = 'male';
        } else {
            $new_user->gender = 'female';
        }
        /*check date*/
        $is_date_correct = self::checkDateFormat($input['birthDate']);

        if (!$is_date_correct) {
            session()->flash('old_value', $input);
            session()->flash('create_doc_error', 3);
            return redirect('createDoctor');
        }
        /*end*/
        $birthDate = substr($input['birthDate'], 6) . "-" . substr($input['birthDate'], 0, 2) . '-' . substr($input['birthDate'], 3, 2);
        $new_user->birthDate = $birthDate;
        $new_user->phoneNumber = $input['phoneNumber'];
        /*check phone number*/
        $is_pn_correct = self::checkPhoneNumberFormat($input['phoneNumber']);

        if (!$is_pn_correct) {
            session()->flash('old_value', $input);
            session()->flash('create_doc_error', 4);
            return redirect('createDoctor');
        }
        /*end*/
        $new_user->email = $input['email'];
        /*check email*/
        $is_email_coorect = self::checkEmailFormat($input['email']);

        if (!$is_email_coorect) {
            session()->flash('old_value', $input);
            session()->flash('create_doc_error', 6);
            return redirect('createDoctor');
        }
        /*end*/
        $at_pos = strpos($input['email'], '@');
        $new_user->username = substr($input['email'], 0, $at_pos) . "_wc";
        /*check username & doctorNumber*/

        if (count(User::where('username', $new_user->username)->get()) > 0) {
            session()->flash('old_value', $input);
            session()->flash('create_doc_error', 2);
            return redirect('createDoctor');
        }

        if (count(Doctor::where('doctorNumber', $input['doctorNumber'])->get()) > 0) {
            session()->flash('old_value', $input);
            session()->flash('create_doc_error', 2);
            return redirect('createDoctor');
        }
        /*end*/
        $new_pass = self::generatePassword();
        $new_user->password = bcrypt($new_pass);
        $new_user->address = $input['address'];
        /*thai or eng*/
        $new_user->userType = 'doctor';
        try {
            $new_user->save();

        } catch (Exception $e) {
            session()->flash('old_value', $input);
            session()->flash('create_doc_error', 2);
            return redirect('createDoctor');
        }
        $new_doctor->doctorId = $new_user->userId;
        $target_dep = Department::where('departmentName', $input['department'])->first();
        $new_doctor->departmentId = $target_dep->departmentId;
        $new_doctor->doctorNumber = $input['doctorNumber'];

        try {
            $new_doctor->save();

        } catch (Exception $e) {
            session()->flash('old_value', $input);
            session()->flash('create_doc_error', 2);
            return redirect('createDoctor');
        }
        $new_schedule = new Schedule;
        $new_schedule->monPeriod = $input['mon_mor'] + $input['mon_af'];
        $new_schedule->tuePeriod = $input['tue_mor'] + $input['tue_af'];
        $new_schedule->wedPeriod = $input['wed_mor'] + $input['wed_af'];
        $new_schedule->thuPeriod = $input['thu_mor'] + $input['thu_af'];
        $new_schedule->friPeriod = $input['fri_mor'] + $input['fri_af'];
        $new_schedule->satPeriod = $input['sat_mor'] + $input['sat_af'];
        $new_schedule->sunPeriod = $input['sun_mor'] + $input['sun_af'];
        $new_schedule->doctorId = $new_doctor->doctorId;
        try {
            $new_schedule->save();

        } catch (Exception $e) {
            session()->flash('old_value', $input);
            session()->flash('create_doc_error', 2);
            return redirect('createDoctor');
        }
        session()->flash('account_owner', $new_user->firstname . ' ' . $new_user->lastname);
        session()->flash('generated_username', $new_user->username);
        session()->flash('generated_password', $new_pass);
        return redirect('manageAccount');
    }

    public function create_nurse_form()
    {
        $available_deps = Department::all();
        return view('admin.createNurse', compact('available_deps'));
    }

    public function create_nurse()
    {
        $input = Request::all();

        if (!isset($input['gender'])) {
            $input['gender'] = '';
            session()->flash('old_value', $input);
            session()->flash('create_nurse_error', 1);
            return redirect('createNurse');
        }

        if ($input['firstname'] == '' or $input['lastname'] == '' or $input['ssn'] == '' or $input['nurseNumber'] == '' or $input['birthDate'] == '' or $input['email'] == '' or $input['phoneNumber'] == '' or $input['address'] == '') {
            session()->flash('old_value', $input);
            session()->flash('create_nurse_error', 1);
            return redirect('createNurse');
        }
        $new_user = new User;
        $new_nurse = new Nurse;
        $new_user->firstname = $input['firstname'];
        $new_user->lastname = $input['lastname'];
        $new_user->idNumber = $input['ssn'];
        /*check ssn*/
        $is_ssn_correct = self::checkSSNFormat($input['ssn']);

        if (!$is_ssn_correct) {
            session()->flash('old_value', $input);
            session()->flash('create_nurse_error', 5);
            return redirect('createNurse');
        }
        /*end*/
        if ($input['gender'] == 'ชาย') {
            $new_user->gender = 'male';
        } else {
            $new_user->gender = 'female';
        }
        /*check date*/
        $is_date_correct = self::checkDateFormat($input['birthDate']);

        if (!$is_date_correct) {
            session()->flash('old_value', $input);
            session()->flash('create_nurse_error', 3);
            return redirect('createNurse');
        }
        /*end*/
        $birthDate = substr($input['birthDate'], 6) . "-" . substr($input['birthDate'], 0, 2) . '-' . substr($input['birthDate'], 3, 2);
        $new_user->birthDate = $birthDate;
        $new_user->phoneNumber = $input['phoneNumber'];
        /*check phone number*/
        $is_pn_correct = self::checkPhoneNumberFormat($input['phoneNumber']);

        if (!$is_pn_correct) {
            session()->flash('old_value', $input);
            session()->flash('create_nurse_error', 4);
            return redirect('createNurse');
        }
        /*end*/
        $new_user->email = $input['email'];
        /*check email*/
        $is_email_coorect = self::checkEmailFormat($input['email']);

        if (!$is_email_coorect) {
            session()->flash('old_value', $input);
            session()->flash('create_nurse_error', 6);
            return redirect('createNurse');
        }
        /*end*/
        $at_pos = strpos($input['email'], '@');
        $new_user->username = substr($input['email'], 0, $at_pos) . "_wc";
        /*check username & nurseNumber*/

        if (count(User::where('username', $new_user->username)->get()) > 0) {
            session()->flash('old_value', $input);
            session()->flash('create_nurse_error', 2);
            return redirect('createNurse');
        }

        if (count(Nurse::where('nurseNumber', $input['nurseNumber'])->get()) > 0) {
            session()->flash('old_value', $input);
            session()->flash('create_nurse_error', 2);
            return redirect('createNurse');
        }
        /*end*/
        $new_pass = self::generatePassword();
        $new_user->password = bcrypt($new_pass);
        $new_user->address = $input['address'];
        /*thai or eng*/
        $new_user->userType = 'nurse';
        try {
            $new_user->save();

        } catch (Exception $e) {
            session()->flash('old_value', $input);
            session()->flash('create_nurse_error', 2);
            return redirect('createNurse');
        }
        $new_nurse->nurseId = $new_user->userId;
        $target_dep = Department::where('departmentName', $input['department'])->first();
        $new_nurse->departmentId = $target_dep->departmentId;
        $new_nurse->nurseNumber = $input['nurseNumber'];
        try {
            $new_nurse->save();

        } catch (Exception $e) {
            session()->flash('old_value', $input);
            session()->flash('create_nurse_error', 2);
            return redirect('createNurse');
        }
        session()->flash('account_owner', $new_user->firstname . ' ' . $new_user->lastname);
        session()->flash('generated_username', $new_user->username);
        session()->flash('generated_password', $new_pass);
        return redirect('manageAccount');
    }

    public function create_pharmacist_form()
    {
        return view('admin.createPharmacist');
    }

    public function create_pharmacist()
    {
        $input = Request::all();

        if (!isset($input['gender'])) {
            $input['gender'] = '';
            session()->flash('old_value', $input);
            session()->flash('create_phar_error', 1);
            return redirect('createPharmacist');
        }

        if ($input['firstname'] == '' or $input['lastname'] == '' or $input['ssn'] == '' or $input['pharmacistNumber'] == '' or $input['birthDate'] == '' or $input['email'] == '' or $input['phoneNumber'] == '' or $input['address'] == '') {
            session()->flash('old_value', $input);
            session()->flash('create_phar_error', 1);
            return redirect('createPharmacist');
        }
        $new_user = new User;
        $new_pharmacist = new Pharmacist;
        $new_user->firstname = $input['firstname'];
        $new_user->lastname = $input['lastname'];
        $new_user->idNumber = $input['ssn'];
        /*check ssn*/
        $is_ssn_correct = self::checkSSNFormat($input['ssn']);

        if (!$is_ssn_correct) {
            session()->flash('old_value', $input);
            session()->flash('create_phar_error', 5);
            return redirect('createPharmacist');
        }
        /*end*/
        if ($input['gender'] == 'ชาย') {
            $new_user->gender = 'male';
        } else {
            $new_user->gender = 'female';
        }
        /*check date*/
        $is_date_correct = self::checkDateFormat($input['birthDate']);

        if (!$is_date_correct) {
            session()->flash('old_value', $input);
            session()->flash('create_phar_error', 3);
            return redirect('createPharmacist');
        }
        /*end*/
        $birthDate = substr($input['birthDate'], 6) . "-" . substr($input['birthDate'], 0, 2) . '-' . substr($input['birthDate'], 3, 2);
        $new_user->birthDate = $birthDate;
        $new_user->phoneNumber = $input['phoneNumber'];
        /*check phone number*/
        $is_pn_correct = self::checkPhoneNumberFormat($input['phoneNumber']);

        if (!$is_pn_correct) {
            session()->flash('old_value', $input);
            session()->flash('create_phar_error', 4);
            return redirect('createPharmacist');
        }
        /*end*/
        $new_user->email = $input['email'];
        /*check email*/
        $is_email_coorect = self::checkEmailFormat($input['email']);

        if (!$is_email_coorect) {
            session()->flash('old_value', $input);
            session()->flash('create_phar_error', 6);
            return redirect('createPharmacist');
        }
        /*end*/
        $at_pos = strpos($input['email'], '@');
        $new_user->username = substr($input['email'], 0, $at_pos) . "_wc";
        /*check username & pharmacistNumber*/

        if (count(User::where('username', $new_user->username)->get()) > 0) {
            session()->flash('old_value', $input);
            session()->flash('create_phar_error', 2);
            return redirect('createPharmacist');
        }

        if (count(Pharmacist::where('pharmacistNumber', $input['pharmacistNumber'])->get()) > 0) {
            session()->flash('old_value', $input);
            session()->flash('create_phar_error', 2);
            return redirect('createPharmacist');
        }
        /*end*/
        $new_pass = self::generatePassword();
        $new_user->password = bcrypt($new_pass);
        $new_user->address = $input['address'];
        /*thai or eng*/
        $new_user->userType = 'pharmacist';
        try {
            $new_user->save();

        } catch (Exception $e) {
            session()->flash('old_value', $input);
            session()->flash('create_phar_error', 2);
            return redirect('createPharmacist');
        }
        $new_pharmacist->pharmacistId = $new_user->userId;
        $new_pharmacist->pharmacistNumber = $input['pharmacistNumber'];
        try {
            $new_pharmacist->save();

        } catch (Exception $e) {
            session()->flash('old_value', $input);
            session()->flash('create_phar_error', 2);
            return redirect('createPharmacist');
        }
        session()->flash('account_owner', $new_user->firstname . ' ' . $new_user->lastname);
        session()->flash('generated_username', $new_user->username);
        session()->flash('generated_password', $new_pass);
        return redirect('manageAccount');
    }

    public function create_admin_form()
    {
        return view('admin.createAdmin');
    }

    public function create_admin()
    {
        $input = Request::all();

        if (!isset($input['gender'])) {
            $input['gender'] = '';
            session()->flash('old_value', $input);
            session()->flash('create_admin_error', 1);
            return redirect('createAdmin');
        }

        if ($input['firstname'] == '' or $input['lastname'] == '' or $input['ssn'] == '' or $input['adminNumber'] == '' or $input['birthDate'] == '' or $input['email'] == '' or $input['phoneNumber'] == '' or $input['address'] == '') {
            session()->flash('old_value', $input);
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

        if (!$is_ssn_correct) {
            session()->flash('old_value', $input);
            session()->flash('create_admin_error', 5);
            return redirect('createAdmin');
        }
        /*end*/
        if ($input['gender'] == 'ชาย') {
            $new_user->gender = 'male';
        } else {
            $new_user->gender = 'female';
        }
        /*check date*/
        $is_date_correct = self::checkDateFormat($input['birthDate']);

        if (!$is_date_correct) {
            session()->flash('old_value', $input);
            session()->flash('create_admin_error', 3);
            return redirect('createAdmin');
        }
        /*end*/
        $birthDate = substr($input['birthDate'], 6) . "-" . substr($input['birthDate'], 0, 2) . '-' . substr($input['birthDate'], 3, 2);
        $new_user->birthDate = $birthDate;
        $new_user->phoneNumber = $input['phoneNumber'];
        /*check phone number*/
        $is_pn_correct = self::checkPhoneNumberFormat($input['phoneNumber']);

        if (!$is_pn_correct) {
            session()->flash('old_value', $input);
            session()->flash('create_admin_error', 4);
            return redirect('createAdmin');
        }
        /*end*/
        $new_user->email = $input['email'];
        /*check email*/
        $is_email_coorect = self::checkEmailFormat($input['email']);

        if (!$is_email_coorect) {
            session()->flash('old_value', $input);
            session()->flash('create_admin_error', 6);
            return redirect('createAdmin');
        }
        /*end*/
        $at_pos = strpos($input['email'], '@');
        $new_user->username = substr($input['email'], 0, $at_pos) . "_wc";
        /*check username & adminNumber*/

        if (count(User::where('username', $new_user->username)->get()) > 0) {
            session()->flash('old_value', $input);
            session()->flash('create_admin_error', 2);
            return redirect('createAdmin');
        }

        if (count(Admin::where('adminNumber', $input['adminNumber'])->get()) > 0) {
            session()->flash('old_value', $input);
            session()->flash('create_admin_error', 2);
            return redirect('createAdmin');
        }
        $new_pass = self::generatePassword();
        $new_user->password = bcrypt($new_pass);
        $new_user->address = $input['address'];
        /*thai or eng*/
        $new_user->userType = 'admin';
        try {
            $new_user->save();

        } catch (Exception $e) {
            session()->flash('old_value', $input);
            session()->flash('create_admin_error', 2);
            return redirect('createAdmin');
        }
        $new_admin->adminId = $new_user->userId;
        $new_admin->adminNumber = $input['adminNumber'];
        try {
            $new_admin->save();

        } catch (Exception $e) {
            session()->flash('old_value', $input);
            session()->flash('create_admin_error', 2);
            return redirect('createAdmin');
        }
        session()->flash('account_owner', $new_user->firstname . ' ' . $new_user->lastname);
        session()->flash('generated_username', $new_user->username);
        session()->flash('generated_password', $new_pass);
        return redirect('manageAccount');
    }
}
