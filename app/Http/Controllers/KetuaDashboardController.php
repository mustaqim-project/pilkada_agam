<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KetuaDashboardController extends Controller
{
    public function kanvasingDashboard() {
        // Query jumlah kanvasing per wilayah
        $kanvasingWilayah = DB::table('kanvasing_wisata as k')
            ->join('kelurahan as kel', 'k.kelurahan_id', '=', 'kel.id')
            ->join('kecamatan as kec', 'kel.kecamatan_id', '=', 'kec.id')
            ->join('wilayah as w', 'kec.wilayah_id', '=', 'w.id')
            ->select('w.nama_wilayah', DB::raw('COUNT(k.id) as total_kanvasing'))
            ->whereDate('k.created_at', now()->toDateString())
            ->groupBy('w.id')
            ->get();

        // Query jumlah kanvasing per kecamatan
        $kanvasingKecamatan = DB::table('kanvasing_wisata as k')
            ->join('kelurahan as kel', 'k.kelurahan_id', '=', 'kel.id')
            ->join('kecamatan as kec', 'kel.kecamatan_id', '=', 'kec.id')
            ->select('kec.nama_kecamatan', DB::raw('COUNT(k.id) as total_kanvasing'))
            ->whereDate('k.created_at', now()->toDateString())
            ->groupBy('kec.id')
            ->get();

        // Query jumlah kanvasing per kelurahan
        $kanvasingKelurahan = DB::table('kanvasing_wisata as k')
            ->join('kelurahan as kel', 'k.kelurahan_id', '=', 'kel.id')
            ->select('kel.nama_kelurahan', DB::raw('COUNT(k.id) as total_kanvasing'))
            ->whereDate('k.created_at', now()->toDateString())
            ->groupBy('kel.id')
            ->get();

        return view('admin.dashboard.ketuatim', compact('kanvasingWilayah', 'kanvasingKecamatan', 'kanvasingKelurahan'));
    }
}
