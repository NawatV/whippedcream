<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiagnosisHistoryController extends Controller
{
    //
    public function editDiagnosisHistory(){
        return view('editDiagnosisHistory');
//        echo 'editDiagnosisHistory';
    }


    public function viewDiagnosisHistory()    {
        return view('viewDiagnosisHistory');
//        echo 'viewDiagnosisHistory';
    }

    public function findPatientFromHnIdName(){
        echo 'test finding Patient';
    }
}
