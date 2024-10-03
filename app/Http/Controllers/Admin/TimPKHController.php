<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimPKHController extends Controller
{
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
