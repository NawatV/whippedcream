<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostponeAppointmentController extends Controller
{
    public static function postponeAppointment($appointment)
    {
        date_default_timezone_set('Asia/Bangkok');
        //get all doctor in the same dep
        $target_doc = $appointment->doctor;
        $target_dep = $target_doc->department;
        $all_doctor = $target_dep->doctor;
        $all_app = [];
        for($i = 0; $i < count($all_doctor); $i++){
        	array_push($all_app, $all_doctor[$i]->appointment);
        }
        //get date and time of postponed appointment
        $base_date = $appointment['appDate'];
        $base_date = new \DateTime($base_date);
        $base_time = $appointment['appTime'];
        if($base_time = '09:00:00'){
            $base_time = 1;
        }
        else{
            $base_time = 2;
        }
        //loop date
        $postponed = False;
        while(!$postponed){
        	$date = $base_date;
        	$date = $date->format('w Y-m-d');
        	$dow = substr($date, 0, 1);
        	$date = substr($date, 2);
        	//loop time
        	for($schedule = $base_time; $schedule <= 2; $schedule++){
	            //loop doctor in dep
	            $time = '';
	            if($schedule == 1){
	            	$time = '9:00';
	            }
	            else{
	            	$time = '13:00';
	            }
	            for($i = 0; $i < count($all_doctor); $i++){
                    if($all_doctor[$i]['doctorNumber'] == $target_doc['doctorNumber']){
                        continue;
                    }
	            	//check doc schedule
	            	$doc_schedule = $all_doctor[$i]->schedule;
	            	$schedule_match = False;
	            	if($dow == 0){
	            		if($doc_schedule['sunPeriod'] == $schedule or $doc_schedule['sunPeriod'] == 3){
	            			$schedule_match = True;
	            		}
	            	}
	            	else if($dow == 1){
	            		if($doc_schedule['monPeriod'] == $schedule or $doc_schedule['monPeriod'] == 3){
	            			$schedule_match = True;
	            		}
	            	}
	            	else if($dow == 2){
	            		if($doc_schedule['tuePeriod'] == $schedule or $doc_schedule['tuePeriod'] == 3){
	            			$schedule_match = True;
	            		}
	            	}
	            	else if($dow == 3){
	            		if($doc_schedule['wedPeriod'] == $schedule or $doc_schedule['wedPeriod'] == 3){
	            			$schedule_match = True;
	            		}
	            	}
	            	else if($dow == 4){
	            		if($doc_schedule['thuPeriod'] == $schedule or $doc_schedule['thuPeriod'] == 3){
	            			$schedule_match = True;
	            		}
	            	}
	            	else if($dow == 5){
	            		if($doc_schedule['friPeriod'] == $schedule or $doc_schedule['friPeriod'] == 3){
	            			$schedule_match = True;
	            		}
	            	}
	            	else if($dow == 6){
	            		if($doc_schedule['satPeriod'] == $schedule or $doc_schedule['satPeriod'] == 3){
	            			$schedule_match = True;
	            		}
	            	}
	            	if($schedule_match){
		            	$all_doc_app = $all_app[$i];
		            	$all_cur_app = [];
		            	for($i2 = 0; $i2 < count($all_doc_app); $i2++){
		            		if($all_doc_app[$i2]['appDate'] == $date and $all_doc_app[$i2]['appTime'] == $time){
		            			array_push($all_cur_app, $all_doc_app[$i2]);
		            		}
		            	}
		            	//check quota
		            	if(count($all_cur_app) >= 15){
		            		continue;
		            	}
		                //if available -> change date & time
		                else{
                            $appointment->doctorId = $all_doctor[$i]['doctorId'];
		                    $appointment->appDate = $date;
		                    $appointment->appTime = $time;
		                    $postponed = True;
		                    break;
		                }
		            }
	            }
	            if($postponed){
	            	break;
	            }
	        }
	        if($postponed){
	            break;
	        }
	        //plus base_date & reset base_time
	        $base_date = $base_date->add(new \DateInterval('P1D'));
	        $base_time = 1;
        }
        $appointment->save();
        //call send change notification
        self::sendEmail($appointment);
        self::sendSms($appointment);
    }

    public static function sendEmail($appointment)
    {
        $target_patient = $appointment->patient;
    	$target_user = $target_patient->user;
    	$target_doctor = $appointment->doctor;
    	$target_dep = $target_doctor->department;
    	$hn = $target_patient['hn'];
    	$name = $target_user['firstname'] . ' ' . $target_user['lastname'];
    	$doctor_name = $target_doctor->user['firstname'] . ' ' . $target_doctor->user['lastname'];
    	if($target_doctor->user['gender'] == 'male'){
    		$doctor_name = 'นายแพทย์' . $doctor_name;
    	}
    	else{
    		$doctor_name = 'แพทย์หญิง' . $doctor_name;
    	}
    	$depName = $target_dep['departmentName'];
    	$depLocation = $target_dep['location'];
    	$date = $appointment['appDate'];
    	$time = $appointment['appTime'];
    	if($time == '9:00'){
    		$time = '9:00 - 11:30';
    	}
    	else{
    		$time = '13:00 - 15:30';
    	}
        $title = 'แจ้งการเปลี่ยนแปลงการนัดหมาย';
        $content = 'ทางโรงพยาบาลได้เปลี่ยนวันนัดหมายของคุณ ' . $name . ' (HN: ' . $hn . ') กับทางแผนก' . $depName . ' (สถานที่: ' . $depLocation . ') เป็นวันที่ ' . $date . ' เวลา ' . $time . 'กับ' . $doctor_name;
        $content .= '<p>Inside p tag</p>';
        Mail::send('email.send', ['title' => $title, 'content' => $content], function ($message) {
            $message->from('whippedcream@hotmail.com', 'Tkk24');
            $message->to($target_user['email']);
            $message->subject('Email from WhippedCream System');
        });
        return back();
    }

    public static function sendSms($appointment)
    {
    	$target_patient = $appointment->patient;
    	$target_user = $target_patient->user;
    	$target_doctor = $appointment->doctor;
    	$target_dep = $target_doctor->department;
    	$hn = $target_patient['hn'];
    	$name = $target_user['firstname'] . ' ' . $target_user['lastname'];
    	$doctor_name = $target_doctor->user['firstname'] . ' ' . $target_doctor->user['lastname'];
    	if($target_doctor->user['gender'] == 'male'){
    		$doctor_name = 'นายแพทย์' . $doctor_name;
    	}
    	else{
    		$doctor_name = 'แพทย์หญิง' . $doctor_name;
    	}
    	$depName = $target_dep['departmentName'];
    	$depLocation = $target_dep['location'];
    	$date = $appointment['appDate'];
    	$time = $appointment['appTime'];
    	if($time == '9:00'){
    		$time = '9:00 - 11:30';
    	}
    	else{
    		$time = '13:00 - 15:30';
    	}
        $url = "https://sms.gipsic.com/api/send";
        $data = array(
            'key' => 'lj13D83fe7vi4QYpB4rP4S707XRhr5Ya',
            'secret' => 'LmqK5guuSIdvwy1iF538182D2Wu4Wm44',
            'phone' => $target_user['phoneNumber'],
            'sender' => '0969155659',
            'message' => 'ทางโรงพยาบาลได้เปลี่ยนวันนัดหมายของคุณ ' . $name . ' (HN: ' . $hn . ') กับทางแผนก' . $depName . ' (สถานที่: ' . $depLocation . ') เป็นวันที่ ' . $date . ' เวลา ' . $time . 'กับ' . $doctor_name
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
        $patients = array();
        return back();
    }
}
