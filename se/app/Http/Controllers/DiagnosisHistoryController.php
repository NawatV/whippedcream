<?php

namespace App\Http\Controllers;

use App\Model\Appointment;
use App\Model\Diagnosis;
use App\Model\Doctor;
use App\Model\Patient;
use App\Model\Prescription;
use App\Model\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

class DiagnosisHistoryController extends Controller
{
//     public function editDiagnosisHistory()
//     {
// //        $patients = Patient::all();
//         $patients = array();
//         return view('editDiagnosisHistory', compact('patients'));
//     }
//
//     public function viewDiagnosisHistory()
//     {
//         return view('viewDiagnosisHistory');
//     }

    public function editDiagnosisHistoryForm(Diagnosis $diagnosis)
    {
        return view('editDiagnosisHistoryForm', compact('diagnosis'));
    }

    public function confirm(Request $request)
    {
        $diagnosis = Diagnosis::where('diagnosisId', $request->diagnosisId)->first();
        $diagnosis->symptomcode = $request->newSymptomcode;
        $diagnosis->diagnosisDetail = $request->newDiagnosisDetail;
        $diagnosis->save();
        return back();
//        return redirect()->route('login');
    }

    public function delete($diagnosisId)
    {
        $diag = Diagnosis::where('diagnosisId', $diagnosisId);
        return dd($diag);
        // return $diag;
        $diag->delete();
        return back();
    }

    public function findPatientFromHnIdNameForDiagnosis(Request $request)
    {
        $patients_hn = $request->input('userId');

        $patients = User::where('userId', $patients_hn)->first();


        $appointments = Appointment::where('patientId', $patients_hn)->get();
        $diagnoses = Diagnosis::where('patientId', $patients_hn)->get();

        $doctors = array();
        foreach ($diagnoses as $diagnosis) {
            $doctorFromDiag = User::where('userId', $diagnosis->doctorId)->first();
            array_push($doctors, $doctorFromDiag);
        }

        return view('editDiagnosisHistoryFoundPatient', compact('patients', 'appointments', 'diagnoses', 'doctors'));
    }

//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========


    public function sendEmail()
    {

        $title = 'This is the title of the email';
        $content = 'This is the content of the Email คอนเท็นภาษาไทย 日本語';
        $content .= '<p>Inside p tag</p>';

        Mail::send('email.send', ['title' => $title, 'content' => $content], function ($message) {

            $message->from('whippedcream@hotmail.com', 'Tkk24');
            $message->to('pisanu15193@yahoo.com');
            $message->subject('Email from WhippedCream System');
        });


        return back();


    }

//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========

    public function sendSms()
    {

        $url = "https://sms.gipsic.com/api/send";
        $data = array(
            'key' => 'lj13D83fe7vi4QYpB4rP4S707XRhr5Ya',
            'secret' => 'LmqK5guuSIdvwy1iF538182D2Wu4Wm44',
//            'phone' => '0874894249',
            'phone' => '0969155659',
            'sender' => '0969155659',
            'message' => 'เชรี่ยยยยยยย กูส่งได้แล้ววววววว'
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
