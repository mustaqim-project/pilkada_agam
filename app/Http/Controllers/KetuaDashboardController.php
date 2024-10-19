<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KetuaDashboardController extends Controller
{
    public function kanvasingDashboard()
    {
        $totalKanvasing = DB::table('kanvasing_wisata')->count();

        // Kanvasing Mingguan
        $kanvasingMingguan = DB::table('kanvasing_wisata')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        // Kanvasing Harian
        $kanvasingHarian = DB::table('kanvasing_wisata')
            ->whereDate('created_at', now())
            ->count();

        // Jumlah Kanvasing berdasarkan Wilayah, Kecamatan, dan Kelurahan
        $kanvasingPerLokasi = DB::table('kanvasing_wisata as kw')
            ->join('kelurahan as kel', 'kw.kelurahan_id', '=', 'kel.id')
            ->join('kecamatan as kec', 'kel.kecamatan_id', '=', 'kec.id')
            ->join('wilayah as w', 'kec.wilayah_id', '=', 'w.id')
            ->select('w.nama_wilayah', 'kec.nama_kecamatan', 'kel.nama_kelurahan', DB::raw('COUNT(kw.id) as total_kanvasing'))
            ->groupBy('w.nama_wilayah', 'kec.nama_kecamatan', 'kel.nama_kelurahan')
            ->get();

        return view('admin.dashboard.ketuatim',  compact('totalKanvasing', 'kanvasingMingguan', 'kanvasingHarian', 'kanvasingPerLokasi'));
    }

}
