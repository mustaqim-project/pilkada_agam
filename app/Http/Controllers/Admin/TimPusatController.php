<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimPusatController extends Controller
{
    public function ketuaDashboard()
    {
        // Logika untuk menampilkan dashboard ketua tim
        return view('admin.timpusatds.ketua.dashboard');
    }

    public function ketuaLaporan()
    {
        // Logika untuk menampilkan laporan ketua tim
        return view('admin.timpusatds.ketua.laporan');
    }

    public function adminDashboard()
    {
        // Logika untuk menampilkan dashboard admin
        return view('admin.timpusatds.admin.dashboard');
    }

    public function adminLaporan()
    {
        // Logika untuk menampilkan laporan admin
        return view('admin.timpusatds.admin.laporan');
    }

    public function index()
    {
        // Logika untuk menampilkan keuangan DS
        return view('admin.timpusatds.index');
    }
}
