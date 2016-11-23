<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrescriptionHistoryController extends Controller
{
    //
    public function editPrescriptionHistory(){
        return view('editPrescriptionHistory');
    }


    public function viewPrescriptionHistory()    {
        return view('viewPrescriptionHistory');
    }
}


