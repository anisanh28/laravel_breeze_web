<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    function index (){
        return view('login');
    }
    function login (Request $request){
        $request->validate([
            'nis' =>'required',
            'password'=>'required'
        ],[
            'nis.required'=>'NIS wajib diisi',
            'password.required'=>'Password wajib diisi',
        ]);

        $infologin = [
            'nis'=>$request->nis,
            'password'=>$request->password,
        ];

        if(Auth::attempt($infologin)){
            return redirect ('/teacher');
        }else{
            return redirect('')->withErrors('NIS dan password yang dimasukkan tidak sesuai')->withInput();
        }
    }
}
