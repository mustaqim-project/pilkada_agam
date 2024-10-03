<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class TimDsController extends Controller
{

    public function __construct()
    {
        // Middleware untuk Ketua
        $this->middleware(['permission:view ketua dashboard,admin'])->only('ketuaDashboard');
        $this->middleware(['permission:view ketua laporan,admin'])->only('ketuaLaporan');

        // Middleware untuk Koordinator Wilayah
        $this->middleware(['permission:view koordinator wilayah dashboard,admin'])->only('koordinatorWilayahDashboard');
        $this->middleware(['permission:view koordinator wilayah laporan,admin'])->only('koordinatorWilayahLaporan');

        // Middleware untuk Koordinator Kecamatan
        $this->middleware(['permission:view koordinator kecamatan dashboard,admin'])->only('koordinatorKecamatanDashboard');
        $this->middleware(['permission:view koordinator kecamatan laporan,admin'])->only('koordinatorKecamatanLaporan');

        // Middleware untuk Koordinator Nagari
        $this->middleware(['permission:view koordinator nagari dashboard,admin'])->only('koordinatorNagariDashboard');
        $this->middleware(['permission:view koordinator nagari laporan,admin'])->only('koordinatorNagariLaporan');
    }
    public function ketuaDashboard()
    {
        return view('admin.timds.ketua.dashboard');
    }

    public function ketuaLaporan()
    {
        return view('admin.timds.ketua.laporan');
    }

    // Koordinator Wilayah
    public function koordinatorWilayahDashboard()
    {
        return view('admin.timds.koordinator_wilayah.dashboard');
    }

    public function koordinatorWilayahLaporan()
    {
        return view('admin.timds.koordinator_wilayah.laporan');
    }

    // Koordinator Kecamatan
    public function koordinatorKecamatanDashboard()
    {
        return view('admin.timds.koordinator_kecamatan.dashboard');
    }

    public function koordinatorKecamatanLaporan()
    {
        return view('admin.timds.koordinator_kecamatan.laporan');
    }

    // Koordinator Nagari
    public function koordinatorNagariDashboard()
    {
        return view('admin.timds.koordinator_nagari.dashboard');
    }

    public function koordinatorNagariLaporan()
    {
        return view('admin.timds.koordinator_nagari.laporan');
    }
}
