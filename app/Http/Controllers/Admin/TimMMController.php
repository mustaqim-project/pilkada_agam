<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimMMController extends Controller
{
    public function ketuaDashboard()
    {
        return view('admin.timmm.ketua.dashboard');
    }

    public function ketuaLaporan()
    {
        return view('admin.timmm.ketua.laporan');
    }

    // Koordinator Wilayah
    public function koordinatorWilayahDashboard()
    {
        return view('admin.timmm.koordinator_wilayah.dashboard');
    }

    public function koordinatorWilayahLaporan()
    {
        return view('admin.timmm.koordinator_wilayah.laporan');
    }

    // Koordinator Kecamatan
    public function koordinatorKecamatanDashboard()
    {
        return view('admin.timmm.koordinator_kecamatan.dashboard');
    }

    public function koordinatorKecamatanLaporan()
    {
        return view('admin.timmm.koordinator_kecamatan.laporan');
    }

    // Koordinator Nagari
    public function koordinatorNagariDashboard()
    {
        return view('admin.timmm.koordinator_nagari.dashboard');
    }

    public function koordinatorNagariLaporan()
    {
        return view('admin.timmm.koordinator_nagari.laporan');
    }
}
