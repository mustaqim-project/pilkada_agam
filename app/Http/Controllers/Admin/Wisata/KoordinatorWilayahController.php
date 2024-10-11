<?php

namespace App\Http\Controllers\Admin\Wisata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KoordinatorWilayahController extends Controller
{
    // Fungsi untuk halaman dashboard
    public function dashboard()
    {
        // Logika untuk menampilkan data di halaman dashboard
        return view('admin.timwisata.koordinator.wilayah.dashboard');
    }

    // Fungsi untuk halaman laporan
    public function laporan()
    {
        // Logika untuk menampilkan data laporan
        return view('admin.timwisata.koordinator.wilayah.laporan');
    }
}
