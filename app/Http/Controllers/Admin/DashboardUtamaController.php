<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\tim;
use App\Models\anggaran;
use App\Models\periode;
use App\Models\jenis_pembiayaan;
use App\Models\laporan_kegiatan;
use App\Models\kanvasing_ds;
use App\Models\kanvasing_pkh;
use App\Models\kanvasing_mm;
use App\Models\kanvasing_aisyiah;
use App\Models\kanvasing_parpol;
use App\Models\kanvasing_jj;
use App\Models\spanduk_ds;
use App\Models\spanduk_pkh;
use App\Models\spanduk_mm;
use App\Models\spanduk_aisyiah;
// use App\Models\spanduk_parpol;
use App\Models\spanduk_jj;
use App\Models\data_ganda;
use App\Models\KanvasingWisata;

class DashboardUtamaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Dashboard Utama,admin'])->only(['index']);
    }

    public function index()
    {
        $counts = [
            'Tim' => tim::count(),
            'Anggaran' => anggaran::count(),
            'Periode' => periode::count(),
            'Jenis Pembiayaan' => jenis_pembiayaan::count(),
            'Laporan Kegiatan' => laporan_kegiatan::count(),
            'Kanvasing DS' => kanvasing_ds::count(),
            'Kanvasing PKH' => kanvasing_pkh::count(),
            'Kanvasing Muhammdiyah' => kanvasing_mm::count(),
            'Kanvasing Aisyiah' => kanvasing_aisyiah::count(),
            'Kanvasing Wisata' => KanvasingWisata::count(),
            'Data Ganda' => data_ganda::select('no_ktp')->groupBy('no_ktp')->havingRaw('COUNT(no_ktp) > 1')->get()->count(),
        ];

        return view('admin.dashboard.dashboard-utama', compact('counts'));
    }



    public function kanvasing()
    {
        $counts = [
            'Kanvasing DS' => kanvasing_ds::count(),
            'Kanvasing PKH' => kanvasing_pkh::count(),
            'Kanvasing Muhammdiyah' => kanvasing_mm::count(),
            'Kanvasing Aisyiah' => kanvasing_aisyiah::count(),
            'Kanvasing Wisata' => KanvasingWisata::count(),
            'Data Ganda' => data_ganda::select('no_ktp')->groupBy('no_ktp')->havingRaw('COUNT(no_ktp) > 1')->get()->count(),
        ];

        return view('admin.dashboard.dashboard-kanvasing', compact('counts'));
    }
}
