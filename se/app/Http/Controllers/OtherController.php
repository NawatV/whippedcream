<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OtherController extends Controller
{
    //
    public function blankPage(Request $request){
        return view ('blank', compact('request'));
    }

    public function homepage(Request $request){

        return view('homepage', compact('request'));
    }

    public function logout(){
        session()->flush();
        return redirect('/');
    }
}
