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
//     //
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
//        dd($diagnosis);
//        return $diagnosis;
        return view('editDiagnosisHistoryForm', compact('diagnosis'));
    }

    public function confirm(Request $request)
    {
        $diagnosis = Diagnosis::where('diagnosisId', $request->diagnosisId)->first();
        $diagnosis->symptomcode = $request->newSymptomcode;
        $diagnosis->diagnosisDetail = $request->newDiagnosisDetail;
        $diagnosis->save();
        return back();
//        http://localhost/editDiagnosisHistory
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
//        $patients = array();
//        $patients = Patient::all();



        $patients_hn = $request->input('userId');

        $patients = User::where('userId', $patients_hn)->first();


        $appointments = Appointment::where('patientId', $patients_hn)->get();
        $diagnoses = Diagnosis::where('patientId', $patients_hn)->get();

        $doctors = array();
        foreach ($diagnoses as $diagnosis) {
            $doctorFromDiag = User::where('userId', $diagnosis->doctorId)->first();
            array_push($doctors, $doctorFromDiag);
        }

//        $diagnoses = array();

//        $prescription = Prescription::where('patientId', $patients_hn)->get();

//        $name = $patients[0]->firstname;

//        dd($name);


        return view('editDiagnosisHistoryFoundPatient', compact('patients', 'appointments', 'diagnoses', 'doctors'));
    }


    //    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========


    public function sendEmail()
    {
//        $email = $_POST['email'];
//
//        $subject = 'Your subject for email';
//        $message = 'Body of your message';
//
//        mail($email, $subject, $message);
//
//
//        $patients = array();
//        return view('editDiagnosisHistory', compact('patients'));


//        return array(
//            "driver" => "smtp",
//            "host" => "mailtrap.io",
//            "port" => 2525,
//            "from" => array(
//                "address" => "from@example.com",
//                "name" => "Example"
//            ),
//            "username" => "1f7fc9abe0fdeb",
//            "password" => "5d9e8180de7489",
//            "sendmail" => "/usr/sbin/sendmail -bs",
//            "pretend" => false
//        );


//        $title = $request->input('title');
//        $content = $request->input('content');
//
//        Mail::send('emails.send', ['title' => $title, 'content' => $content], function ($message)
//        {
//
//            $message->from('me@gmail.com', 'Christian Nwamba');
//
//            $message->to('chrisn@scotch.io');
//
//        });
//
//        return response()->json(['message' => 'Request completed']);


        $title = 'This is the title of the email';
        $content = 'This is the content of the Email คอนเท็นภาษาไทย 日本語';
        $content .= '<p>Inside p tag</p>';

        Mail::send('email.send', ['title' => $title, 'content' => $content], function ($message) {

            $message->from('whippedcream@hotmail.com', 'Tkk24');
            $message->to('pisanu15193@yahoo.com');
            $message->subject('Email from WhippedCream System');
        });

//        return response()->json(['message' => 'Request completed']);

        return back();

//
//            $user = 'emailOfUser@gmail.com';
//
//        Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
//            $m->from('hello@app.com', 'Your Application');
//
//            $m->to($user->email, $user->name)->subject('Your Reminder!');
//        });


    }



//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
//    ========= ========= ========= ========= ========= ========= ========= ========= ========= ========= =========
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

//        if ($status != 201) {
//            die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
//        }

        curl_close($curl);

        $response = json_decode($json_response, true);

//        echo $response;
//        return $response;
        $patients = array();


        return back();


    }

}
