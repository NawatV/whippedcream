<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrescriptionHistoryController extends Controller
{
    //
    public function editPrescriptionHistory(){
        return view('editPrescriptionHistory');
//        echo 'editPrescriptionHistory';
    }


    public function viewPrescriptionHistory()    {
        return view('viewPrescriptionHistory');
//        echo 'viewPrescriptionHistory';
    }
}


