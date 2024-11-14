<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(){
        return view('dashboard');
    }
    public function materi(){
        return view('materi');
    }
}
