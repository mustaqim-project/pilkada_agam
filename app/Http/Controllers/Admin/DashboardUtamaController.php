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
        // Menghitung data dari setiap model
        $counts = [
            'tim' => tim::count(),
            'anggaran' => anggaran::count(),
            'periode' => periode::count(),
            'jenis_pembiayaan' => jenis_pembiayaan::count(),
            'laporan_kegiatan' => laporan_kegiatan::count(),
            'kanvasing_ds' => kanvasing_ds::count(),
            'kanvasing_pkh' => kanvasing_pkh::count(),
            'kanvasing_mm' => kanvasing_mm::count(),
            'kanvasing_aisyiah' => kanvasing_aisyiah::count(),
            'kanvasing_parpol' => kanvasing_parpol::count(),
            'kanvasing_jj' => KanvasingWisata::count(),
            'spanduk_ds' => spanduk_ds::count(),
            'spanduk_pkh' => spanduk_pkh::count(),
            'spanduk_mm' => spanduk_mm::count(),
            'spanduk_aisyiah' => spanduk_aisyiah::count(),
            // 'spanduk_parpol' => spanduk_parpol::count(),
            'spanduk_jj' => spanduk_jj::count(),
            'data_ganda' => data_ganda::count(),
        ];

        return view('admin.dashboard.dashboard-utama', compact('counts'));
    }
}
