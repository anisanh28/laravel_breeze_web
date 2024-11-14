<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Materi; // Import the Materi model
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $jumlahSiswa = User::where('role', 'siswa')->count();
        return view('guru.dashboard', compact('jumlahSiswa'));
    }

    public function materi()
    {
        // Retrieve all data from the materi table
        $materi = Materi::all();
        
        // Pass the data to the view
        return view('guru.materi', compact('materi'));
    }

    public function anggota()
    {
        $siswa = User::where('role', 'siswa')->get();
        return view('guru.anggota', compact('siswa'));
    }
}
